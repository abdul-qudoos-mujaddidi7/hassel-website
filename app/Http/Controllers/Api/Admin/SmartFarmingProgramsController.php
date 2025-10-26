<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SmartFarmingProgram;
use App\Services\TranslationSyncService;

class SmartFarmingProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $query = SmartFarmingProgram::query()->orderBy('created_at', 'desc');
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'farming_type' => 'nullable|string',
            'target_crops' => 'nullable|array',
            'sustainability_level' => 'nullable|string',
            'implementation_guide' => 'nullable|string',
            'sustainability_impact' => 'nullable|string',
            'duration' => 'nullable|string',
            'location' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'status' => 'required|string|in:draft,open,closed,published',
            'translations' => 'sometimes|array',
        ]);

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = SmartFarmingProgram::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => $item], 201);
    }

    public function show(SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $smartFarmingProgram]);
    }

    public function update(Request $request, SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
            'short_description' => 'sometimes|nullable|string',
            'farming_type' => 'sometimes|nullable|string',
            'target_crops' => 'sometimes|nullable|array',
            'sustainability_level' => 'sometimes|nullable|string',
            'implementation_guide' => 'sometimes|nullable|string',
            'sustainability_impact' => 'sometimes|nullable|string',
            'duration' => 'sometimes|nullable|string',
            'location' => 'sometimes|nullable|string',
            'application_deadline' => 'sometimes|nullable|date',
            'status' => 'sometimes|required|string|in:draft,open,closed,published',
            'translations' => 'sometimes|array',
        ]);

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $smartFarmingProgram->update($validated);
        TranslationSyncService::sync($smartFarmingProgram, $translations);

        return response()->json(['success' => true, 'data' => $smartFarmingProgram]);
    }

    public function destroy(SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        $smartFarmingProgram->delete();
        return response()->json(['success' => true]);
    }
}
