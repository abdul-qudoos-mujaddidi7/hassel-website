<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    /**
     * Get news list with pagination and language support
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $news = News::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        // Apply translations if needed
        if ($language !== 'en') {
            $news->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->excerpt = $item->getTranslation('excerpt', $language);
                return $item;
            });
        }

        return response()->json($news);
    }

    /**
     * Get single news article with related articles
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $news->title = $news->getTranslation('title', $language);
            $news->content = $news->getTranslation('content', $language);
            $news->excerpt = $news->getTranslation('excerpt', $language);
        }

        // Get related news (3 most recent, excluding current)
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        // Apply translations to related news
        if ($language !== 'en') {
            $relatedNews->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->excerpt = $item->getTranslation('excerpt', $language);
                return $item;
            });
        }

        return response()->json([
            'news' => $news,
            'related_news' => $relatedNews
        ]);
    }
}
