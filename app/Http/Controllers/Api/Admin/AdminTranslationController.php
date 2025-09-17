<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdminTranslationController extends Controller
{
    /**
     * Display a listing of translations
     */
    public function index(Request $request): JsonResponse
    {
        $query = Translation::with('model');

        if ($request->has('language')) {
            $query->forLanguage($request->language);
        }

        if ($request->has('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->has('field_name')) {
            $query->forField($request->field_name);
        }

        if ($request->has('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }

        $translations = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($translations);
    }

    /**
     * Store a newly created translation
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'model_type' => 'required|string|max:255',
            'model_id' => 'required|integer',
            'field_name' => 'required|string|max:255',
            'language' => 'required|in:pashto,farsi',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if translation already exists for this combination
        $exists = Translation::where('model_type', $request->model_type)
            ->where('model_id', $request->model_id)
            ->where('field_name', $request->field_name)
            ->where('language', $request->language)
            ->exists();

        if ($exists) {
            return response()->json([
                'errors' => ['translation' => ['Translation for this field and language already exists.']]
            ], 422);
        }

        $translation = Translation::create($validator->validated());

        return response()->json([
            'message' => 'Translation created successfully',
            'translation' => $translation
        ], 201);
    }

    /**
     * Display the specified translation
     */
    public function show(Translation $translation): JsonResponse
    {
        return response()->json(['translation' => $translation->load('model')]);
    }

    /**
     * Update the specified translation
     */
    public function update(Request $request, Translation $translation): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $translation->update(['content' => $request->content]);

        return response()->json([
            'message' => 'Translation updated successfully',
            'translation' => $translation->fresh()
        ]);
    }

    /**
     * Remove the specified translation
     */
    public function destroy(Translation $translation): JsonResponse
    {
        $translation->delete();

        return response()->json([
            'message' => 'Translation deleted successfully'
        ]);
    }

    /**
     * Get translations for a specific model
     */
    public function forModel(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $translations = Translation::forModel($request->model_type, $request->model_id)
            ->get()
            ->groupBy(['language', 'field_name']);

        return response()->json(['translations' => $translations]);
    }

    /**
     * Bulk create/update translations for a model
     */
    public function bulkStore(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'model_type' => 'required|string|max:255',
            'model_id' => 'required|integer',
            'translations' => 'required|array',
            'translations.*.field_name' => 'required|string|max:255',
            'translations.*.language' => 'required|in:pashto,farsi',
            'translations.*.content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $created = 0;
        $updated = 0;

        foreach ($request->translations as $translationData) {
            $translation = Translation::updateOrCreate(
                [
                    'model_type' => $request->model_type,
                    'model_id' => $request->model_id,
                    'field_name' => $translationData['field_name'],
                    'language' => $translationData['language'],
                ],
                [
                    'content' => $translationData['content'],
                ]
            );

            if ($translation->wasRecentlyCreated) {
                $created++;
            } else {
                $updated++;
            }
        }

        return response()->json([
            'message' => "Translations processed: {$created} created, {$updated} updated",
            'created' => $created,
            'updated' => $updated,
        ]);
    }

    /**
     * Get translation statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => Translation::count(),
            'by_language' => Translation::selectRaw('language, count(*) as count')
                ->groupBy('language')
                ->get()
                ->pluck('count', 'language'),
            'by_model_type' => Translation::selectRaw('model_type, count(*) as count')
                ->groupBy('model_type')
                ->get()
                ->pluck('count', 'model_type'),
            'recent' => Translation::orderBy('created_at', 'desc')->limit(10)->get(),
        ]);
    }
}
