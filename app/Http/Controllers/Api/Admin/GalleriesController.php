<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Services\TranslationSyncService;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\GalleryResource;

class GalleriesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = Gallery::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => GalleryResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(GalleryRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $gallery = Gallery::create($validated);
        TranslationSyncService::sync($gallery, $translations);

        return response()->json(['success' => true, 'data' => new GalleryResource($gallery)], 201);
    }

    public function show(Gallery $gallery): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new GalleryResource($gallery->load('images'))]);
    }

    public function update(GalleryRequest $request, Gallery $gallery): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $gallery->update($validated);
        TranslationSyncService::sync($gallery, $translations);

        return response()->json(['success' => true, 'data' => new GalleryResource($gallery)]);
    }

    public function destroy(Gallery $gallery): JsonResponse
    {
        $gallery->delete();
        return response()->json(['success' => true]);
    }
}
