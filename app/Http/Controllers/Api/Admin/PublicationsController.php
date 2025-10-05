<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicationRequest;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TranslationSyncService;

class PublicationsController extends Controller
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
            $fileType = $request->get('file_type', '');

            $query = Publication::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($fileType) {
                $query->where('file_type', $fileType);
            }

            $publications = $query->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $publications->items(),
                'meta' => [
                    'total' => $publications->total(),
                    'per_page' => $publications->perPage(),
                    'current_page' => $publications->currentPage(),
                    'last_page' => $publications->lastPage(),
                ],
                'message' => 'Publications retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve publications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PublicationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);
            $publication = Publication::create($validated);
            TranslationSyncService::sync($publication, $translations);

            return response()->json([
                'success' => true,
                'data' => $publication,
                'message' => 'Publication created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create publication',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $publication,
                'message' => 'Publication retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve publication',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PublicationRequest $request, Publication $publication): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);
            $publication->update($validated);
            TranslationSyncService::sync($publication, $translations);

            return response()->json([
                'success' => true,
                'data' => $publication,
                'message' => 'Publication updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update publication',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication): JsonResponse
    {
        try {
            $publication->delete();

            return response()->json([
                'success' => true,
                'message' => 'Publication deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete publication',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get published publications
     */
    public function published(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);
            $search = $request->get('search', '');

            $query = Publication::published();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            $publications = $query->orderBy('published_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $publications->items(),
                'meta' => [
                    'total' => $publications->total(),
                    'per_page' => $publications->perPage(),
                    'current_page' => $publications->currentPage(),
                    'last_page' => $publications->lastPage(),
                ],
                'message' => 'Published publications retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve published publications',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get publications by file type
     */
    public function byFileType(Request $request, string $fileType): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);

            $publications = Publication::published()
                ->where('file_type', $fileType)
                ->orderBy('published_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $publications->items(),
                'meta' => [
                    'total' => $publications->total(),
                    'per_page' => $publications->perPage(),
                    'current_page' => $publications->currentPage(),
                    'last_page' => $publications->lastPage(),
                ],
                'message' => "Publications with file type {$fileType} retrieved successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve publications by file type',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get publication statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => Publication::count(),
                'published' => Publication::published()->count(),
                'draft' => Publication::draft()->count(),
                'by_file_type' => Publication::published()
                    ->selectRaw('file_type, COUNT(*) as count')
                    ->groupBy('file_type')
                    ->get()
                    ->pluck('count', 'file_type')
                    ->toArray(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Publication statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve publication statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
