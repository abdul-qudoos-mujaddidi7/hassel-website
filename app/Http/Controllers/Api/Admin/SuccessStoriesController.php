<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\SuccessStory;
use App\Services\TranslationSyncService;
use App\Services\FileUploadService;
use App\Http\Resources\SuccessStoryResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class SuccessStoriesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $query = SuccessStory::query()->orderBy('created_at', 'desc');
        $stories = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $stories->items(),
            'meta' => [
                'total' => $stories->total(),
                'per_page' => $stories->perPage(),
                'current_page' => $stories->currentPage(),
                'last_page' => $stories->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
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

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255',
                'author_name' => 'nullable|string|max:255', // Maps to client_name
                'author_title' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'content' => 'required|string', // Maps to story
                'featured_image' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                            $fail('The featured image must be a string or a valid image file.');
                        }
                        if (is_string($value) && strlen($value) > 500) {
                            $fail('The featured image URL may not be greater than 500 characters.');
                        }
                        if ($value instanceof \Illuminate\Http\UploadedFile) {
                            $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                            if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                                $fail('The featured image must be a file of type: jpeg, jpg, png, gif, webp.');
                            }
                            if ($value->getSize() > 3072 * 1024) {
                                $fail('The featured image may not be greater than 3MB.');
                            }
                        }
                    }
                ],
                'status' => 'required|string|in:draft,published,archived',
                'published_at' => 'nullable|date',
                'translations' => 'sometimes|array',
            ]);

            // Map form fields to database fields
            $validated['client_name'] = $validated['author_name'] ?? null;
            $validated['story'] = $validated['content'] ?? null;
            unset($validated['author_name'], $validated['author_title'], $validated['location'], $validated['content']);

            // Handle featured image upload if provided
            if ($request->hasFile('featured_image')) {
                try {
                    $uploadService = app(FileUploadService::class);
                    $imagePath = $uploadService->upload($request->file('featured_image'), 'featured_image');
                    $validated['image'] = Storage::url($imagePath);
                } catch (\Exception $e) {
                    Log::error('Image upload error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to upload image: ' . $e->getMessage(),
                        'error' => $e->getMessage()
                    ], 422);
                }
            } elseif (isset($validated['featured_image']) && $validated['featured_image'] !== '') {
                // String URL provided
                $validated['image'] = $validated['featured_image'];
            } else {
                $validated['image'] = null;
            }
            unset($validated['featured_image']);

            $translations = $validated['translations'] ?? [];
            unset($validated['translations']);

            $story = SuccessStory::create($validated);
            TranslationSyncService::sync($story, $translations);

            return response()->json(['success' => true, 'data' => $story], 201);
        } catch (\Exception $e) {
            Log::error('Success story creation error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create success story',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, SuccessStory $successStory): JsonResponse
    {
        if ($request->boolean('include_translations')) {
            $successStory->load('translations');
        }
        return response()->json([
            'success' => true,
            'data' => (new SuccessStoryResource($successStory))->resolve($request)
        ]);
    }

    public function update(Request $request, SuccessStory $successStory): JsonResponse
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

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'slug' => 'sometimes|nullable|string|max:255',
                'author_name' => 'sometimes|nullable|string|max:255',
                'author_title' => 'sometimes|nullable|string|max:255',
                'location' => 'sometimes|nullable|string|max:255',
                'content' => 'sometimes|required|string',
                'featured_image' => [
                    'nullable',
                    function ($attribute, $value, $fail) {
                        if ($value === '' || $value === null) {
                            return;
                        }
                        if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                            $fail('The featured image must be a string or a valid image file.');
                            return;
                        }
                        if (is_string($value) && strlen($value) > 500) {
                            $fail('The featured image URL may not be greater than 500 characters.');
                            return;
                        }
                        if ($value instanceof \Illuminate\Http\UploadedFile) {
                            $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                            if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                                $fail('The featured image must be a file of type: jpeg, jpg, png, gif, webp.');
                                return;
                            }
                            if ($value->getSize() > 3072 * 1024) {
                                $fail('The featured image may not be greater than 3MB.');
                                return;
                            }
                        }
                    }
                ],
                'status' => 'sometimes|required|string|in:draft,published,archived',
                'published_at' => 'sometimes|nullable|date',
                'translations' => 'sometimes|array',
            ]);

            // Map form fields to database fields
            if (isset($validated['author_name'])) {
                $validated['client_name'] = $validated['author_name'];
                unset($validated['author_name']);
            }
            if (isset($validated['content'])) {
                $validated['story'] = $validated['content'];
                unset($validated['content']);
            }
            unset($validated['author_title'], $validated['location']);

            // Handle featured image upload/removal
            if ($request->hasFile('featured_image')) {
                // New file uploaded - replace existing image
                $uploadService = app(FileUploadService::class);
                $oldImagePath = null;
                if ($successStory->image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($successStory->image, PHP_URL_PATH));
                }
                $imagePath = $uploadService->replace($request->file('featured_image'), 'featured_image', $oldImagePath);
                $validated['image'] = Storage::url($imagePath);
            } elseif ($request->has('featured_image') && $request->input('featured_image') === '') {
                // Empty string sent - clear the existing image
                if ($successStory->image) {
                    $oldImagePath = str_replace('/storage/', '', parse_url($successStory->image, PHP_URL_PATH));
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                $validated['image'] = null;
            } elseif (isset($validated['featured_image']) && !$request->hasFile('featured_image')) {
                // String URL provided
                $validated['image'] = $validated['featured_image'];
            }
            unset($validated['featured_image']);

            $translations = $validated['translations'] ?? [];
            unset($validated['translations']);

            $successStory->update($validated);
            TranslationSyncService::sync($successStory, $translations);

            return response()->json(['success' => true, 'data' => $successStory]);
        } catch (\Exception $e) {
            Log::error('Success story update error: ' . $e->getMessage() . PHP_EOL . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update success story',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(SuccessStory $successStory): JsonResponse
    {
        $successStory->delete();
        return response()->json(['success' => true]);
    }
}
