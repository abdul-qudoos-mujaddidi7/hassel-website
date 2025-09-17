<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    /**
     * Display a listing of news articles
     */
    public function index(Request $request): JsonResponse
    {
        $query = News::query();

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $news = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($news);
    }

    /**
     * Store a newly created news article
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:news,slug|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $data['featured_image'] = $imagePath;
        }

        // Set published_at if status is published and no date provided
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $news = News::create($data);

        return response()->json([
            'message' => 'News article created successfully',
            'news' => $news
        ], 201);
    }

    /**
     * Display the specified news article
     */
    public function show(News $news): JsonResponse
    {
        return response()->json(['news' => $news]);
    }

    /**
     * Update the specified news article
     */
    public function update(Request $request, News $news): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:news,slug,' . $news->id . '|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('news', 'public');
            $data['featured_image'] = $imagePath;
        }

        // Set published_at if status changed to published and no date provided
        if ($data['status'] === 'published' && $news->status !== 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return response()->json([
            'message' => 'News article updated successfully',
            'news' => $news->fresh()
        ]);
    }

    /**
     * Remove the specified news article
     */
    public function destroy(News $news): JsonResponse
    {
        // Delete featured image if exists
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        // Delete associated translations
        $news->translations()->delete();

        $news->delete();

        return response()->json([
            'message' => 'News article deleted successfully'
        ]);
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:news,id',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $count = News::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'message' => "{$count} news articles updated successfully"
        ]);
    }

    /**
     * Get news statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => News::count(),
            'published' => News::published()->count(),
            'draft' => News::draft()->count(),
            'archived' => News::where('status', 'archived')->count(),
        ]);
    }
}
