<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SeedSupplyProgram;
use App\Services\TranslationSyncService;
use App\Http\Requests\SeedSupplyProgramRequest;
use App\Http\Resources\SeedSupplyProgramResource;

class SeedSupplyProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $inputType = $request->get('input_type', '');

        $query = SeedSupplyProgram::query()->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('target_crops', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($inputType) {
            $query->where('input_type', $inputType);
        }

        $items = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => SeedSupplyProgramResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(SeedSupplyProgramRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = SeedSupplyProgram::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => new SeedSupplyProgramResource($item)], 201);
    }

    public function show(SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new SeedSupplyProgramResource($seedSupplyProgram)]);
    }

    public function update(SeedSupplyProgramRequest $request, SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $seedSupplyProgram->update($validated);
        TranslationSyncService::sync($seedSupplyProgram, $translations);

        return response()->json(['success' => true, 'data' => new SeedSupplyProgramResource($seedSupplyProgram)]);
    }

    public function destroy(SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        $seedSupplyProgram->delete();
        return response()->json(['success' => true]);
    }
}
