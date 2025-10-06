<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SuccessStory;
use App\Services\TranslationSyncService;
use App\Http\Resources\SuccessStoryResource;

class SuccessStoriesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $query = SuccessStory::query()->orderBy('created_at', 'desc');
        $stories = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $stories->items(),
            'meta' => [
                'total' => $stories->total(),
                'per_page' => $stories->perPage(),
                'current_page' => $stories->currentPage(),
                'last_page' => $stories->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'client_name' => 'nullable|string|max:255',
            'story' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'required|string|in:draft,published',
            'published_at' => 'nullable|date',
            'translations' => 'sometimes|array',
        ]);

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $story = SuccessStory::create($validated);
        TranslationSyncService::sync($story, $translations);

        return response()->json(['success' => true, 'data' => $story], 201);
    }

    public function show(Request $request, SuccessStory $successStory): JsonResponse
    {
        if ($request->boolean('include_translations')) {
            $successStory->load('translations');
        }
        return response()->json([
            'success' => true,
            'data' => (new SuccessStoryResource($successStory))->resolve($request)
        ]);
    }

    public function update(Request $request, SuccessStory $successStory): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|nullable|string|max:255',
            'client_name' => 'sometimes|nullable|string|max:255',
            'story' => 'sometimes|nullable|string',
            'image' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|string|in:draft,published',
            'published_at' => 'sometimes|nullable|date',
            'translations' => 'sometimes|array',
        ]);

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $successStory->update($validated);
        TranslationSyncService::sync($successStory, $translations);

        return response()->json(['success' => true, 'data' => $successStory]);
    }

    public function destroy(SuccessStory $successStory): JsonResponse
    {
        $successStory->delete();
        return response()->json(['success' => true]);
    }
}
