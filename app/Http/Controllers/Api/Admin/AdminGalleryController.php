<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of galleries
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gallery::with('images');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $galleries = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($galleries);
    }

    /**
     * Store a newly created gallery
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:galleries,slug|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('galleries/covers', 'public');
            $data['cover_image'] = $coverImagePath;
        }

        $gallery = Gallery::create($data);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('galleries/' . $gallery->id, 'public');

                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $imagePath,
                    'alt_text' => $data['title'] . ' - Image ' . ($index + 1),
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => $gallery->load('images')
        ], 201);
    }

    /**
     * Display the specified gallery
     */
    public function show(Gallery $gallery): JsonResponse
    {
        return response()->json(['gallery' => $gallery->load('images')]);
    }

    /**
     * Update the specified gallery
     */
    public function update(Request $request, Gallery $gallery): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:galleries,slug,' . $gallery->id . '|max:255',
            'description' => 'nullable|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
            if ($gallery->cover_image) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $coverImagePath = $request->file('cover_image')->store('galleries/covers', 'public');
            $data['cover_image'] = $coverImagePath;
        }

        $gallery->update($data);

        return response()->json([
            'message' => 'Gallery updated successfully',
            'gallery' => $gallery->fresh()->load('images')
        ]);
    }

    /**
     * Remove the specified gallery
     */
    public function destroy(Gallery $gallery): JsonResponse
    {
        // Delete cover image if exists
        if ($gallery->cover_image) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        // Delete all gallery images
        foreach ($gallery->images as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        // Delete associated translations and images
        $gallery->translations()->delete();
        $gallery->images()->delete();
        $gallery->delete();

        return response()->json([
            'message' => 'Gallery deleted successfully'
        ]);
    }

    /**
     * Add images to gallery
     */
    public function addImages(Request $request, Gallery $gallery): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lastSortOrder = $gallery->images()->max('sort_order') ?? 0;

        foreach ($request->file('images') as $index => $image) {
            $imagePath = $image->store('galleries/' . $gallery->id, 'public');

            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image_path' => $imagePath,
                'alt_text' => $gallery->title . ' - Image ' . ($lastSortOrder + $index + 1),
                'sort_order' => $lastSortOrder + $index + 1,
            ]);
        }

        return response()->json([
            'message' => count($request->file('images')) . ' images added successfully',
            'gallery' => $gallery->fresh()->load('images')
        ]);
    }

    /**
     * Remove image from gallery
     */
    public function removeImage(Gallery $gallery, GalleryImage $image): JsonResponse
    {
        // Verify the image belongs to this gallery
        if ($image->gallery_id !== $gallery->id) {
            return response()->json(['message' => 'Image not found in this gallery'], 404);
        }

        // Delete the file
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json([
            'message' => 'Image removed successfully'
        ]);
    }
}
