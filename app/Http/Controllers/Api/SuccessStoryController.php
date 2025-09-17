<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SuccessStoryResource;

class SuccessStoryController extends Controller
{
    /**
     * Get success stories list with pagination and language support
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $stories = SuccessStory::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return SuccessStoryResource::collection($stories);
    }

    /**
     * Get single success story
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $story = SuccessStory::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related success stories
        $relatedStories = SuccessStory::published()
            ->where('id', '!=', $story->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'story' => new SuccessStoryResource($story),
            'related_stories' => SuccessStoryResource::collection($relatedStories)
        ]);
    }
}
