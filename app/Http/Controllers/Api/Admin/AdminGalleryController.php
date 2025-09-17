<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Requests\GalleryRequest;
use App\Http\Resources\GalleryResource;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of galleries
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Gallery::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $galleries = $query->with('images')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return GalleryResource::collection($galleries);
    }

    /**
     * Store a newly created gallery
     */
    public function store(GalleryRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('galleries/covers', 'public');
            $data['cover_image'] = $coverPath;
        }

        $gallery = Gallery::create($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('galleries/' . $gallery->id, 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $imagePath,
                    'alt_text' => $data['title'] ?? '',
                    'sort_order' => 0
                ]);
            }
        }

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => new GalleryResource($gallery->load('images'))
        ], 201);
    }

    /**
     * Display the specified gallery
     */
    public function show(Gallery $gallery): JsonResponse
    {
        return response()->json([
            'gallery' => new GalleryResource($gallery->load('images'))
        ]);
    }

    /**
     * Update the specified gallery
     */
    public function update(GalleryRequest $request, Gallery $gallery): JsonResponse
    {
        $data = $request->validated();

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image
            if ($gallery->cover_image) {
                Storage::disk('public')->delete($gallery->cover_image);
            }

            $coverPath = $request->file('cover_image')->store('galleries/covers', 'public');
            $data['cover_image'] = $coverPath;
        }

        $gallery->update($data);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('galleries/' . $gallery->id, 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $imagePath,
                    'alt_text' => $data['title'] ?? '',
                    'sort_order' => 0
                ]);
            }
        }

        return response()->json([
            'message' => 'Gallery updated successfully',
            'gallery' => new GalleryResource($gallery->load('images'))
        ]);
    }

    /**
     * Remove the specified gallery
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        // Delete gallery images
        foreach ($gallery->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        // Delete cover image
        if ($gallery->cover_image) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        $gallery->delete();

        return response()->json([
            'message' => 'Gallery deleted successfully'
        ]);
    }

    /**
     * Remove a specific image from gallery
     */
    public function removeImage(Gallery $gallery, GalleryImage $image): JsonResponse
    {
        if ($image->gallery_id !== $gallery->id) {
            return response()->json(['message' => 'Image not found in gallery'], 404);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json([
            'message' => 'Image removed successfully'
        ]);
    }

    /**
     * Bulk operations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:galleries,id',
            'action' => 'required|in:publish,unpublish,archive,delete',
        ]);

        $galleries = Gallery::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $galleries->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $galleries->update(['status' => 'draft']);
                break;
            case 'archive':
                $galleries->update(['status' => 'archived']);
                break;
            case 'delete':
                foreach ($galleries->get() as $gallery) {
                    $this->destroy($gallery);
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
            'total_galleries' => Gallery::count(),
            'published_galleries' => Gallery::published()->count(),
            'draft_galleries' => Gallery::draft()->count(),
            'total_images' => GalleryImage::count(),
        ]);
    }
}
