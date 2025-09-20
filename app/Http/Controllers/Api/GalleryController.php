<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\GalleryResource;

class GalleryController extends Controller
{
    /**
     * Get galleries list with pagination and language support
     */
    public function index(Request $request)
    {
        $language = $request->get('lang', 'en');

        $galleries = Gallery::published()
            ->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return GalleryResource::collection($galleries);
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

        // Get related galleries (same category or recent)
        $relatedGalleries = Gallery::published()
            ->where('id', '!=', $gallery->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'gallery' => new GalleryResource($gallery),
            'related_galleries' => GalleryResource::collection($relatedGalleries)
        ]);
    }
}
