<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\MarketAccessProgram;
use App\Services\TranslationSyncService;
use App\Http\Requests\MarketAccessProgramRequest;
use App\Http\Resources\MarketAccessProgramResource;
use App\Services\FileUploadService;
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
        return response()->json([
            'success' => true,
            'data' => MarketAccessProgramResource::collection($items),
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

    public function show(MarketAccessProgram $marketAccessProgram): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new MarketAccessProgramResource($marketAccessProgram)]);
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
                $uploadService = app(FileUploadService::class);
                $oldImagePath = null;
                if ($marketAccessProgram->cover_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($marketAccessProgram->cover_image, PHP_URL_PATH));
                }
                $imagePath = $uploadService->replace($request->file('cover_image'), 'cover_image', $oldImagePath);
                $validated['cover_image'] = Storage::url($imagePath);
            } elseif ($request->has('cover_image') && $request->input('cover_image') === '') {
                if ($marketAccessProgram->cover_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($marketAccessProgram->cover_image, PHP_URL_PATH));
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                $validated['cover_image'] = null;
            }

            // Handle thumbnail image upload/removal
            if ($request->hasFile('thumbnail_image')) {
                $uploadService = app(FileUploadService::class);
                $oldImagePath = null;
                if ($marketAccessProgram->thumbnail_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($marketAccessProgram->thumbnail_image, PHP_URL_PATH));
                }
                $imagePath = $uploadService->replace($request->file('thumbnail_image'), 'cover_image', $oldImagePath);
                $validated['thumbnail_image'] = Storage::url($imagePath);
            } elseif ($request->has('thumbnail_image') && $request->input('thumbnail_image') === '') {
                if ($marketAccessProgram->thumbnail_image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($marketAccessProgram->thumbnail_image, PHP_URL_PATH));
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
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
