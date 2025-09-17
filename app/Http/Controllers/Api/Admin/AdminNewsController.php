<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\NewsRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\FileUploadService;

class AdminNewsController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
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
    public function store(NewsRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->fileUploadService->upload(
                $request->file('featured_image'),
                'featured_image',
                'news'
            );
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
    public function update(NewsRequest $request, News $news): JsonResponse
    {
        $data = $request->validated();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->fileUploadService->replace(
                $request->file('featured_image'),
                'featured_image',
                $news->featured_image,
                'news'
            );
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
            $this->fileUploadService->delete($news->featured_image);
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
