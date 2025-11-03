<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingProgramRequest;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TranslationSyncService;
use App\Services\FileUploadService;
use App\Http\Resources\TrainingProgramResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TrainingProgramsController extends Controller
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
            $programType = $request->get('program_type', '');

            $query = TrainingProgram::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('instructor', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($programType) {
                $query->where('program_type', $programType);
            }

            $trainingPrograms = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Always include translations for admin list and respect lang
            $request->merge([
                'include_translations' => true,
                'lang' => $request->get('lang', 'en'),
            ]);
            $data = collect($trainingPrograms->items())->map(function ($item) use ($request) {
                return (new TrainingProgramResource($item))->resolve($request);
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'meta' => [
                    'total' => $trainingPrograms->total(),
                    'per_page' => $trainingPrograms->perPage(),
                    'current_page' => $trainingPrograms->currentPage(),
                    'last_page' => $trainingPrograms->lastPage(),
                ],
                'message' => 'Training programs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve training programs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingProgramRequest $request): JsonResponse
    {
        try {
            // Parse translations if it's a JSON string (from FormData)
            if ($request->has('translations') && is_string($request->input('translations'))) {
                try {
                    $translationsArray = json_decode($request->input('translations'), true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($translationsArray)) {
                        $request->merge(['translations' => $translationsArray]);
                    }
                } catch (\Exception $e) {
                    // If parsing fails, set to empty array
                    $request->merge(['translations' => []]);
                }
            }

            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Handle cover image upload if provided
            if ($request->hasFile('cover_image')) {
                try {
                    $uploadService = app(FileUploadService::class);
                    $imagePath = $uploadService->upload($request->file('cover_image'), 'cover_image');
                    $validated['cover_image'] = Storage::url($imagePath);
                } catch (\Exception $e) {
                    Log::error('Cover image upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload cover image: ' . $e->getMessage(),
                        'error' => $e->getMessage()
                    ], 422);
                }
            } elseif (!$request->has('cover_image') || $request->input('cover_image') === '') {
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload if provided
            if ($request->hasFile('thumbnail_image')) {
                try {
                    $uploadService = app(FileUploadService::class);
                    $imagePath = $uploadService->upload($request->file('thumbnail_image'), 'cover_image');
                    $validated['thumbnail_image'] = Storage::url($imagePath);
                } catch (\Exception $e) {
                    Log::error('Thumbnail image upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload thumbnail image: ' . $e->getMessage(),
                        'error' => $e->getMessage()
                    ], 422);
                }
            } elseif (!$request->has('thumbnail_image') || $request->input('thumbnail_image') === '') {
                $validated['thumbnail_image'] = null;
            }

            $trainingProgram = TrainingProgram::create($validated);
            TranslationSyncService::sync($trainingProgram, $translations);

            return response()->json([
                'success' => true,
                'data' => $trainingProgram,
                'message' => 'Training program created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Training program creation error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, TrainingProgram $trainingProgram): JsonResponse
    {
        try {
            if ($request->boolean('include_translations')) {
                $trainingProgram->load('translations');
            }

            return response()->json([
                'success' => true,
                'data' => (new TrainingProgramResource($trainingProgram))->resolve($request),
                'message' => 'Training program retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrainingProgramRequest $request, TrainingProgram $trainingProgram): JsonResponse
    {
        try {
            // Parse translations if it's a JSON string (from FormData)
            if ($request->has('translations') && is_string($request->input('translations'))) {
                try {
                    $translationsArray = json_decode($request->input('translations'), true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($translationsArray)) {
                        $request->merge(['translations' => $translationsArray]);
                    }
                } catch (\Exception $e) {
                    // If parsing fails, set to empty array
                    $request->merge(['translations' => []]);
                }
            }

            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Handle cover image upload/removal
            if ($request->hasFile('cover_image')) {
                // New file uploaded - replace existing image
                $uploadService = app(FileUploadService::class);
                $oldImagePath = null;
                if ($trainingProgram->cover_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($trainingProgram->cover_image, PHP_URL_PATH));
                }
                $imagePath = $uploadService->replace($request->file('cover_image'), 'cover_image', $oldImagePath);
                $validated['cover_image'] = Storage::url($imagePath);
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                // Empty string sent - clear the existing image
                if ($trainingProgram->cover_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($trainingProgram->cover_image, PHP_URL_PATH));
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                $validated['cover_image'] = null;
            }
            // If cover_image is not in request, it means keep existing value (don't update)

            // Handle thumbnail image upload/removal
            if ($request->hasFile('thumbnail_image')) {
                // New file uploaded - replace existing image
                $uploadService = app(FileUploadService::class);
                $oldImagePath = null;
                if ($trainingProgram->thumbnail_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($trainingProgram->thumbnail_image, PHP_URL_PATH));
                }
                $imagePath = $uploadService->replace($request->file('thumbnail_image'), 'cover_image', $oldImagePath);
                $validated['thumbnail_image'] = Storage::url($imagePath);
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                // Empty string sent - clear the existing image
                if ($trainingProgram->thumbnail_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($trainingProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                $validated['thumbnail_image'] = null;
            }
            // If thumbnail_image is not in request, it means keep existing value (don't update)

            $trainingProgram->update($validated);
            TranslationSyncService::sync($trainingProgram, $translations);

            return response()->json([
                'success' => true,
                'data' => $trainingProgram,
                'message' => 'Training program updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Training program update error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingProgram $trainingProgram): JsonResponse
    {
        try {
            $trainingProgram->delete();

            return response()->json([
                'success' => true,
                'message' => 'Training program deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get published training programs
     */
    public function published(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);
            $search = $request->get('search', '');

            $query = TrainingProgram::published();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            }

            $trainingPrograms = $query->orderBy('start_date', 'asc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $trainingPrograms->items(),
                'meta' => [
                    'total' => $trainingPrograms->total(),
                    'per_page' => $trainingPrograms->perPage(),
                    'current_page' => $trainingPrograms->currentPage(),
                    'last_page' => $trainingPrograms->lastPage(),
                ],
                'message' => 'Published training programs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve published training programs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get upcoming training programs
     */
    public function upcoming(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);

            $trainingPrograms = TrainingProgram::upcoming()
                ->orderBy('start_date', 'asc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $trainingPrograms->items(),
                'meta' => [
                    'total' => $trainingPrograms->total(),
                    'per_page' => $trainingPrograms->perPage(),
                    'current_page' => $trainingPrograms->currentPage(),
                    'last_page' => $trainingPrograms->lastPage(),
                ],
                'message' => 'Upcoming training programs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve upcoming training programs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get program statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => TrainingProgram::count(),
                'published' => TrainingProgram::published()->count(),
                'upcoming' => TrainingProgram::upcoming()->count(),
                'ongoing' => TrainingProgram::ongoing()->count(),
                'completed' => TrainingProgram::completed()->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Training program statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve training program statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
