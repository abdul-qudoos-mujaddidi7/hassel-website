<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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

        // Apply translations if needed
        if ($language !== 'en') {
            $stories->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->story = $item->getTranslation('story', $language);
                $item->client_name = $item->getTranslation('client_name', $language);
                return $item;
            });
        }

        return response()->json($stories);
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

        // Apply translations if needed
        if ($language !== 'en') {
            $story->title = $story->getTranslation('title', $language);
            $story->story = $story->getTranslation('story', $language);
            $story->client_name = $story->getTranslation('client_name', $language);
        }

        // Get related success stories
        $relatedStories = SuccessStory::published()
            ->where('id', '!=', $story->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Apply translations to related stories
        if ($language !== 'en') {
            $relatedStories->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->client_name = $item->getTranslation('client_name', $language);
                return $item;
            });
        }

        return response()->json([
            'story' => $story,
            'related_stories' => $relatedStories
        ]);
    }
}
