<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AgriTechTool;
use App\Services\TranslationSyncService;
use App\Services\FileUploadService;
use App\Http\Requests\AgriTechToolRequest;
use App\Http\Resources\AgriTechToolResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AgriTechToolsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = AgriTechTool::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        
        // Always include translations for admin list
        $request->merge(['include_translations' => true]);
        
        $data = collect($items->items())->map(function ($item) use ($request) {
            return (new AgriTechToolResource($item))->resolve($request);
        });
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(AgriTechToolRequest $request): JsonResponse
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

            $item = AgriTechTool::create($validated);
            TranslationSyncService::sync($item, $translations);

            return response()->json([
                'success' => true,
                'data' => new AgriTechToolResource($item),
                'message' => 'Agri-tech tool created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Agri-tech tool creation error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create agri-tech tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, AgriTechTool $agriTechTool): JsonResponse
    {
        // Include translations for admin edit mode
        if ($request->boolean('include_translations')) {
            $request->merge(['include_translations' => true]);
        }
        
        return response()->json([
            'success' => true,
            'data' => (new AgriTechToolResource($agriTechTool))->resolve($request)
        ]);
    }

    public function update(AgriTechToolRequest $request, AgriTechTool $agriTechTool): JsonResponse
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
                try {
                    $uploadService = app(FileUploadService::class);
                    $oldImagePath = null;
                    if ($agriTechTool->cover_image) {
                        $oldImagePath = str_replace('/storage/', '', parse_url($agriTechTool->cover_image, PHP_URL_PATH));
                    }
                    $imagePath = $uploadService->replace($request->file('cover_image'), 'cover_image', $oldImagePath);
                    $validated['cover_image'] = Storage::url($imagePath);
                } catch (\Exception $e) {
                    Log::error('Cover image upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload cover image: ' . $e->getMessage(),
                        'error' => $e->getMessage()
                    ], 422);
                }
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                // Empty string sent - clear the existing image
                if ($agriTechTool->cover_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($agriTechTool->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
                $validated['cover_image'] = null;
            }
            // If cover_image is not in request, it means keep existing value (don't update)

            // Handle thumbnail image upload/removal
            if ($request->hasFile('thumbnail_image')) {
                // New file uploaded - replace existing image
                try {
                    $uploadService = app(FileUploadService::class);
                    $oldImagePath = null;
                    if ($agriTechTool->thumbnail_image) {
                        $oldImagePath = str_replace('/storage/', '', parse_url($agriTechTool->thumbnail_image, PHP_URL_PATH));
                    }
                    $imagePath = $uploadService->replace($request->file('thumbnail_image'), 'cover_image', $oldImagePath);
                    $validated['thumbnail_image'] = Storage::url($imagePath);
                } catch (\Exception $e) {
                    Log::error('Thumbnail image upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload thumbnail image: ' . $e->getMessage(),
                        'error' => $e->getMessage()
                    ], 422);
                }
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                // Empty string sent - clear the existing image
                if ($agriTechTool->thumbnail_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($agriTechTool->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                }
                $validated['thumbnail_image'] = null;
            }
            // If thumbnail_image is not in request, it means keep existing value (don't update)

            $agriTechTool->update($validated);
            TranslationSyncService::sync($agriTechTool, $translations);

            return response()->json([
                'success' => true,
                'data' => new AgriTechToolResource($agriTechTool),
                'message' => 'Agri-tech tool updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Agri-tech tool update error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update agri-tech tool',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(AgriTechTool $agriTechTool): JsonResponse
    {
        $agriTechTool->delete();
        return response()->json(['success' => true]);
    }
}
