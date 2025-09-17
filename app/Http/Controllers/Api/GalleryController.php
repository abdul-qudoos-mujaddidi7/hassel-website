<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    /**
     * Get galleries list with pagination and language support
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $galleries = Gallery::published()
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Apply translations if needed
        if ($language !== 'en') {
            $galleries->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json($galleries);
    }

    /**
     * Get single gallery with all images
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $gallery = Gallery::where('slug', $slug)
            ->where('status', 'published')
            ->with(['images' => function ($query) {
                $query->orderBy('sort_order', 'asc');
            }])
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $gallery->title = $gallery->getTranslation('title', $language);
            $gallery->description = $gallery->getTranslation('description', $language);
        }

        // Get related galleries (same category or recent)
        $relatedGalleries = Gallery::published()
            ->where('id', '!=', $gallery->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Apply translations to related galleries
        if ($language !== 'en') {
            $relatedGalleries->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json([
            'gallery' => $gallery,
            'related_galleries' => $relatedGalleries
        ]);
    }
}
