<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\MarketAccessProgram;
use App\Services\TranslationSyncService;
use App\Http\Requests\MarketAccessProgramRequest;
use App\Http\Resources\MarketAccessProgramResource;

class MarketAccessProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = MarketAccessProgram::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('target_crops', 'like', "%{$search}%")
                    ->orWhere('partner_organizations', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => MarketAccessProgramResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(MarketAccessProgramRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = MarketAccessProgram::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => new MarketAccessProgramResource($item)], 201);
    }

    public function show(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new MarketAccessProgramResource($marketAccessProgram)]);
    }

    public function update(MarketAccessProgramRequest $request, MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $marketAccessProgram->update($validated);
        TranslationSyncService::sync($marketAccessProgram, $translations);

        return response()->json(['success' => true, 'data' => new MarketAccessProgramResource($marketAccessProgram)]);
    }

    public function destroy(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        $marketAccessProgram->delete();
        return response()->json(['success' => true]);
    }
}
