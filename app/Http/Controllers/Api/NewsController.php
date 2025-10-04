<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\NewsResource;

class NewsController extends Controller
{
    /**
     * Get news list with pagination and language support
     */
    public function index(Request $request)
    {
        $language = $request->get('lang', 'en');
        $perPage = $request->get('per_page', 9);

        $news = News::published()
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);

        return NewsResource::collection($news);
    }

    /**
     * Get single news article with related articles
     */
    public function show(string $slug, Request $request)
    {
        $language = $request->get('lang', 'en');

        $news = News::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related news (3 most recent, excluding current)
        $relatedNews = News::published()
            ->where('id', '!=', $news->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'news' => new NewsResource($news),
            'related_news' => NewsResource::collection($relatedNews)
        ]);
    }
}
