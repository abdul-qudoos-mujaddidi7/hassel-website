<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmartFarmingProgramRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SmartFarmingProgram;
use App\Services\TranslationSyncService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SmartFarmingProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $query = SmartFarmingProgram::query()->orderBy('created_at', 'desc');
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(SmartFarmingProgramRequest $request): JsonResponse
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
                    $request->merge(['translations' => []]);
                }
            }

            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $path = $request->file('cover_image')->store('cover_images', 'public');
                $validated['cover_image'] = Storage::url($path);
            } else {
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload
            if ($request->hasFile('thumbnail_image')) {
                $path = $request->file('thumbnail_image')->store('thumbnail_images', 'public');
                $validated['thumbnail_image'] = Storage::url($path);
            } else {
                $validated['thumbnail_image'] = null;
            }

            // Create program
            $program = SmartFarmingProgram::create($validated);
            TranslationSyncService::sync($program, $translations);

            return response()->json([
                'success' => true,
                'data' => $program,
                'message' => 'Smart farming program created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Smart farming program creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create smart farming program',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function show(SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        return response()->json(['success' => true, 'data' => $smartFarmingProgram]);
    }

    public function update(SmartFarmingProgramRequest $request, SmartFarmingProgram $smartFarmingProgram): JsonResponse
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
                    $request->merge(['translations' => []]);
                }
            }

            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // --- Handle cover image upload/removal ---
            if ($request->hasFile('cover_image')) {
                // Delete old image if exists
                if ($smartFarmingProgram->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($smartFarmingProgram->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('cover_image')->store('cover_images', 'public');
                $validated['cover_image'] = Storage::url($path);
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                // Clear existing image
                if ($smartFarmingProgram->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($smartFarmingProgram->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['cover_image'] = null;
            }

            // --- Handle thumbnail image upload/removal ---
            if ($request->hasFile('thumbnail_image')) {
                if ($smartFarmingProgram->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($smartFarmingProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('thumbnail_image')->store('thumbnail_images', 'public');
                $validated['thumbnail_image'] = Storage::url($path);
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                if ($smartFarmingProgram->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($smartFarmingProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['thumbnail_image'] = null;
            }

            // Update record
            $smartFarmingProgram->update($validated);
            TranslationSyncService::sync($smartFarmingProgram, $translations);

            return response()->json([
                'success' => true,
                'data' => $smartFarmingProgram,
                'message' => 'Smart farming program updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Smart farming program update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update smart farming program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        $smartFarmingProgram->delete();
        return response()->json(['success' => true]);
    }
}
