<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\MarketAccessProgram;
use App\Services\TranslationSyncService;
use App\Http\Requests\MarketAccessProgramRequest;
use App\Http\Resources\MarketAccessProgramResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MarketAccessProgramsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = MarketAccessProgram::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('target_crops', 'like', "%{$search}%")
                    ->orWhere('partner_organizations', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        
        // Always include translations for admin list
        $request->merge(['include_translations' => true]);
        
        $data = collect($items->items())->map(function ($item) use ($request) {
            return (new MarketAccessProgramResource($item))->resolve($request);
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

    public function store(MarketAccessProgramRequest $request): JsonResponse
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

            $item = MarketAccessProgram::create($validated);
            TranslationSyncService::sync($item, $translations);

            return response()->json(['success' => true, 'data' => new MarketAccessProgramResource($item)], 201);
        } catch (\Exception $e) {
            Log::error('Market access program creation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create market access program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        // Include translations for admin edit mode
        if ($request->boolean('include_translations')) {
            $request->merge(['include_translations' => true]);
        }
        
        return response()->json([
            'success' => true,
            'data' => (new MarketAccessProgramResource($marketAccessProgram))->resolve($request)
        ]);
    }

    public function update(MarketAccessProgramRequest $request, MarketAccessProgram $marketAccessProgram): JsonResponse
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

            // Handle cover image upload/removal
            if ($request->hasFile('cover_image')) {
                if ($marketAccessProgram->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($marketAccessProgram->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('cover_image')->store('cover_images', 'public');
                $validated['cover_image'] = Storage::url($path);
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                if ($marketAccessProgram->cover_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($marketAccessProgram->cover_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload/removal
            if ($request->hasFile('thumbnail_image')) {
                if ($marketAccessProgram->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($marketAccessProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $path = $request->file('thumbnail_image')->store('thumbnail_images', 'public');
                $validated['thumbnail_image'] = Storage::url($path);
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                if ($marketAccessProgram->thumbnail_image) {
                    $oldPath = str_replace('/storage/', '', parse_url($marketAccessProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $validated['thumbnail_image'] = null;
            }

            $marketAccessProgram->update($validated);
            TranslationSyncService::sync($marketAccessProgram, $translations);

            return response()->json(['success' => true, 'data' => new MarketAccessProgramResource($marketAccessProgram)]);
        } catch (\Exception $e) {
            Log::error('Market access program update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update market access program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        $marketAccessProgram->delete();
        return response()->json(['success' => true]);
    }
}
