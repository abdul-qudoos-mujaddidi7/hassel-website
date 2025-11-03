<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TranslationSyncService;
use App\Services\FileUploadService;
use App\Http\Resources\NewsResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 15);
            $search = $request->get('search', '');
            $status = $request->get('status', '');

            $query = News::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            $news = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Always include translations for admin routes; pass through lang
            $request->merge([
                'include_translations' => true,
                'lang' => $request->get('lang', 'en'),
            ]);

            // Map each item through resource with current request (so lang applies)
            $data = collect($news->items())->map(function ($item) use ($request) {
                return (new NewsResource($item))->resolve($request);
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'meta' => [
                    'total' => $news->total(),
                    'per_page' => $news->perPage(),
                    'current_page' => $news->currentPage(),
                    'last_page' => $news->lastPage(),
                ],
                'message' => 'News articles retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve news articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Handle featured image upload if provided
            if ($request->hasFile('featured_image')) {
                try {
                    $uploadService = app(FileUploadService::class);
                    $imagePath = $uploadService->upload($request->file('featured_image'), 'featured_image');
                    $validated['featured_image'] = Storage::url($imagePath);
                } catch (\Exception $e) {
                    Log::error('Image upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload image: ' . $e->getMessage(),
                        'error' => $e->getMessage()
                    ], 422);
                }
            } elseif (!$request->has('featured_image') || $request->input('featured_image') === '') {
                // No image provided - set to null for new records
                $validated['featured_image'] = null;
            }

            // Prepare JSON translations
            $farsiTranslations = $translations['farsi'] ?? [];
            $pashtoTranslations = $translations['pashto'] ?? [];
            
            // Add translations to validated data
            $validated['farsi_translations'] = $farsiTranslations;
            $validated['pashto_translations'] = $pashtoTranslations;

            $news = News::create($validated);

            return response()->json([
                'success' => true,
                'data' => $news,
                'message' => 'News article created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('News creation error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create news article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, News $news): JsonResponse
    {
        try {
            // Always include translations for admin routes
            $request->merge(['include_translations' => true]);

            return response()->json([
                'success' => true,
                'data' => (new NewsResource($news))->resolve($request),
                'message' => 'News article retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve news article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateNews(NewsRequest $request, News $news): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Handle featured image upload/removal
            if ($request->hasFile('featured_image')) {
                // New file uploaded - replace existing image
                $uploadService = app(FileUploadService::class);
                // Extract old image path if exists
                $oldImagePath = null;
                if ($news->featured_image) {
                    // Remove leading /storage/ if present, or extract path after /storage/
                    $oldImagePath = str_replace('/storage/', '', parse_url($news->featured_image, PHP_URL_PATH));
                }
                $imagePath = $uploadService->replace($request->file('featured_image'), 'featured_image', $oldImagePath);
                $validated['featured_image'] = Storage::url($imagePath);
            } elseif ($request->has('featured_image') && $request->input('featured_image') === '') {
                // Empty string sent - clear the existing image
                if ($news->featured_image) {
                    // Delete old image file if exists
                    $oldImagePath = str_replace('/storage/', '', parse_url($news->featured_image, PHP_URL_PATH));
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                $validated['featured_image'] = null;
            }
            // If featured_image is not in request, it means keep existing value (don't update)

            // Prepare JSON translations
            $farsiTranslations = $translations['farsi'] ?? [];
            $pashtoTranslations = $translations['pashto'] ?? [];
            
            // Add translations to validated data
            $validated['farsi_translations'] = $farsiTranslations;
            $validated['pashto_translations'] = $pashtoTranslations;

            $news->update($validated);

            return response()->json([
                'success' => true,
                'data' => $news,
                'message' => 'News article updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update news article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news): JsonResponse
    {
        try {
            $news->delete();

            return response()->json([
                'success' => true,
                'message' => 'News article deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete news article',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get published news articles
     */
    public function published(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);
            $search = $request->get('search', '');

            $query = News::published();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%");
                });
            }

            $news = $query->orderBy('published_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $news->items(),
                'meta' => [
                    'total' => $news->total(),
                    'per_page' => $news->perPage(),
                    'current_page' => $news->currentPage(),
                    'last_page' => $news->lastPage(),
                ],
                'message' => 'Published news articles retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve published news articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle publish status
     */
    public function toggleStatus(News $news): JsonResponse
    {
        try {
            $newStatus = $news->status === 'published' ? 'draft' : 'published';
            $news->update([
                'status' => $newStatus,
                'published_at' => $newStatus === 'published' ? now() : null
            ]);

            return response()->json([
                'success' => true,
                'data' => $news,
                'message' => "News article {$newStatus} successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle news article status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
