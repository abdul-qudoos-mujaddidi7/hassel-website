<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\EnvironmentalProject;
use App\Services\TranslationSyncService;
use App\Http\Requests\EnvironmentalProjectRequest;
use App\Http\Resources\EnvironmentalProjectResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class EnvironmentalProjectsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = EnvironmentalProject::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('funding_source', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        
        // Always include translations for admin list
        $request->merge(['include_translations' => true]);
        
        $data = collect($items->items())->map(function ($item) use ($request) {
            return (new EnvironmentalProjectResource($item))->resolve($request);
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

    public function store(EnvironmentalProjectRequest $request): JsonResponse
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
                $path = $request->file('cover_image')->store('cover_images', 'public');
                $validated['cover_image'] = Storage::url($path);
            } else {
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload if provided
            if ($request->hasFile('thumbnail_image')) {
                $path = $request->file('thumbnail_image')->store('thumbnail_images', 'public');
                $validated['thumbnail_image'] = Storage::url($path);
            } else {
                $validated['thumbnail_image'] = null;
            }

            $item = EnvironmentalProject::create($validated);
            TranslationSyncService::sync($item, $translations);

            return response()->json([
                'success' => true,
                'data' => new EnvironmentalProjectResource($item),
                'message' => 'Environmental project created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Environmental project creation error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create environmental project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, EnvironmentalProject $environmentalProject): JsonResponse
    {
        // Include translations for admin edit mode
        if ($request->boolean('include_translations')) {
            $request->merge(['include_translations' => true]);
        }
        
        return response()->json([
            'success' => true,
            'data' => (new EnvironmentalProjectResource($environmentalProject))->resolve($request)
        ]);
    }

    public function update(EnvironmentalProjectRequest $request, EnvironmentalProject $environmentalProject): JsonResponse
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
                if ($environmentalProject->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($environmentalProject->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('cover_image')->store('cover_images', 'public');
                $validated['cover_image'] = Storage::url($path);
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                if ($environmentalProject->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($environmentalProject->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload/removal
            if ($request->hasFile('thumbnail_image')) {
                if ($environmentalProject->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($environmentalProject->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('thumbnail_image')->store('thumbnail_images', 'public');
                $validated['thumbnail_image'] = Storage::url($path);
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                if ($environmentalProject->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($environmentalProject->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['thumbnail_image'] = null;
            }

            $environmentalProject->update($validated);
            TranslationSyncService::sync($environmentalProject, $translations);

            return response()->json([
                'success' => true,
                'data' => new EnvironmentalProjectResource($environmentalProject),
                'message' => 'Environmental project updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Environmental project update error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update environmental project',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(EnvironmentalProject $environmentalProject): JsonResponse
    {
        $environmentalProject->delete();
        return response()->json(['success' => true]);
    }
}
