<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SuccessStoryRequest;
use App\Http\Resources\SuccessStoryResource;

class AdminSuccessStoryController extends Controller
{
    /**
     * Display a listing of success stories
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = SuccessStory::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        $stories = $query->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return SuccessStoryResource::collection($stories);
    }

    /**
     * Store a newly created success story
     */
    public function store(SuccessStoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('client_image')) {
            $imagePath = $request->file('client_image')->store('success-stories', 'public');
            $data['client_image'] = $imagePath;
        }

        $story = SuccessStory::create($data);

        return response()->json([
            'message' => 'Success story created successfully',
            'story' => new SuccessStoryResource($story)
        ], 201);
    }

    /**
     * Display the specified success story
     */
    public function show(SuccessStory $successStory): JsonResponse
    {
        return response()->json([
            'story' => new SuccessStoryResource($successStory)
        ]);
    }

    /**
     * Update the specified success story
     */
    public function update(SuccessStoryRequest $request, SuccessStory $successStory): JsonResponse
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('client_image')) {
            // Delete old image
            if ($successStory->client_image) {
                Storage::disk('public')->delete($successStory->client_image);
            }

            $imagePath = $request->file('client_image')->store('success-stories', 'public');
            $data['client_image'] = $imagePath;
        }

        $successStory->update($data);

        return response()->json([
            'message' => 'Success story updated successfully',
            'story' => new SuccessStoryResource($successStory)
        ]);
    }

    /**
     * Remove the specified success story
     */
    public function destroy(SuccessStory $successStory): JsonResponse
    {
        // Delete associated image
        if ($successStory->client_image) {
            Storage::disk('public')->delete($successStory->client_image);
        }

        $successStory->delete();

        return response()->json([
            'message' => 'Success story deleted successfully'
        ]);
    }

    /**
     * Bulk operations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:success_stories,id',
            'action' => 'required|in:publish,unpublish,archive,delete',
        ]);

        $stories = SuccessStory::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $stories->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $stories->update(['status' => 'draft']);
                break;
            case 'archive':
                $stories->update(['status' => 'archived']);
                break;
            case 'delete':
                foreach ($stories->get() as $story) {
                    $this->destroy($story);
                }
                break;
        }

        return response()->json([
            'message' => ucfirst($request->action) . ' operation completed successfully'
        ]);
    }

    /**
     * Dashboard stats
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total_stories' => SuccessStory::count(),
            'published_stories' => SuccessStory::published()->count(),
            'draft_stories' => SuccessStory::draft()->count(),
        ]);
    }
}
