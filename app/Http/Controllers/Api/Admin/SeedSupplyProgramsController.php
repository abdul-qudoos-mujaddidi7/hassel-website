<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SeedSupplyProgram;
use App\Services\TranslationSyncService;
use App\Http\Requests\SeedSupplyProgramRequest;
use App\Http\Resources\SeedSupplyProgramResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SeedSupplyProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $inputType = $request->get('input_type', '');

        $query = SeedSupplyProgram::query()->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('target_crops', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($inputType) {
            $query->where('input_type', $inputType);
        }

        $items = $query->paginate($perPage);
        
        // Always include translations for admin list
        $request->merge(['include_translations' => true]);
        
        $data = collect($items->items())->map(function ($item) use ($request) {
            return (new SeedSupplyProgramResource($item))->resolve($request);
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

    public function store(SeedSupplyProgramRequest $request): JsonResponse
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

            $item = SeedSupplyProgram::create($validated);
            TranslationSyncService::sync($item, $translations);

            return response()->json([
                'success' => true,
                'data' => new SeedSupplyProgramResource($item),
                'message' => 'Seed supply program created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Seed supply program creation error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create seed supply program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        // Include translations for admin edit mode
        if ($request->boolean('include_translations')) {
            $request->merge(['include_translations' => true]);
        }
        
        return response()->json([
            'success' => true,
            'data' => (new SeedSupplyProgramResource($seedSupplyProgram))->resolve($request)
        ]);
    }

    public function update(SeedSupplyProgramRequest $request, SeedSupplyProgram $seedSupplyProgram): JsonResponse
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
                if ($seedSupplyProgram->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($seedSupplyProgram->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('cover_image')->store('cover_images', 'public');
                $validated['cover_image'] = Storage::url($path);
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                if ($seedSupplyProgram->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($seedSupplyProgram->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload/removal
            if ($request->hasFile('thumbnail_image')) {
                if ($seedSupplyProgram->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($seedSupplyProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('thumbnail_image')->store('thumbnail_images', 'public');
                $validated['thumbnail_image'] = Storage::url($path);
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                if ($seedSupplyProgram->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($seedSupplyProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['thumbnail_image'] = null;
            }

            $seedSupplyProgram->update($validated);
            TranslationSyncService::sync($seedSupplyProgram, $translations);

            return response()->json([
                'success' => true,
                'data' => new SeedSupplyProgramResource($seedSupplyProgram),
                'message' => 'Seed supply program updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Seed supply program update error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update seed supply program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        $seedSupplyProgram->delete();
        return response()->json(['success' => true]);
    }
}
