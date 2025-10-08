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
        $perPage = (int) $request->get('per_page', 9);

        // Optional status filter: published (default) | draft | active (published or draft)
        $status = strtolower((string) $request->get('status', 'published'));

        $query = News::query();
        if ($status === 'active') {
            $query = $query->active();
        } elseif (in_array($status, ['published', 'draft'], true)) {
            $query = $query->where('status', $status);
        } else {
            // default safeguard
            $query = $query->published();
        }

        // Optional ordering
        $orderBy = $request->get('orderBy', 'published_at');
        $direction = strtolower((string) $request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Whitelist orderable columns
        $orderable = ['published_at', 'created_at', 'title'];
        if (!in_array($orderBy, $orderable, true)) {
            $orderBy = 'published_at';
        }

        $news = $query->orderBy($orderBy, $direction)->paginate($perPage);

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
