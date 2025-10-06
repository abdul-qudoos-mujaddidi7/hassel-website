<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CommunityProgram;
use App\Services\TranslationSyncService;
use App\Http\Requests\CommunityProgramRequest;
use App\Http\Resources\CommunityProgramResource;

class CommunityProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = CommunityProgram::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('target_group', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => CommunityProgramResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(CommunityProgramRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = CommunityProgram::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => new CommunityProgramResource($item)], 201);
    }

    public function show(CommunityProgram $communityProgram): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new CommunityProgramResource($communityProgram)]);
    }

    public function update(CommunityProgramRequest $request, CommunityProgram $communityProgram): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $communityProgram->update($validated);
        TranslationSyncService::sync($communityProgram, $translations);

        return response()->json(['success' => true, 'data' => new CommunityProgramResource($communityProgram)]);
    }

    public function destroy(CommunityProgram $communityProgram): JsonResponse
    {
        $communityProgram->delete();
        return response()->json(['success' => true]);
    }
}
