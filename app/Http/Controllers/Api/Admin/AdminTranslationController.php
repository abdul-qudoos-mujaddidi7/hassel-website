<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TranslationResource;

class AdminTranslationController extends Controller
{
    /**
     * Display a listing of translations
     */
    public function index(Request $request): JsonResponse
    {
        $query = Translation::query();

        if ($request->language) {
            $query->where('language', $request->language);
        }

        if ($request->model_type) {
            $query->where('model_type', $request->model_type);
        }

        if ($request->field_name) {
            $query->where('field_name', $request->field_name);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('field_name', 'like', "%{$request->search}%")
                    ->orWhere('translated_value', 'like', "%{$request->search}%");
            });
        }

        $translations = $query->with('model')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return TranslationResource::collection($translations);
    }

    /**
     * Store a newly created translation
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
            'field_name' => 'required|string|max:255',
            'language' => 'required|in:pashto,farsi',
            'translated_value' => 'required|string',
        ]);

        // Check if translation already exists
        $existingTranslation = Translation::where([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
            'field_name' => $request->field_name,
            'language' => $request->language,
        ])->first();

        if ($existingTranslation) {
            $existingTranslation->update(['translated_value' => $request->translated_value]);
            $translation = $existingTranslation;
            $message = 'Translation updated successfully';
        } else {
            $translation = Translation::create($request->validated());
            $message = 'Translation created successfully';
        }

        return response()->json([
            'message' => $message,
            'translation' => new TranslationResource($translation)
        ], $existingTranslation ? 200 : 201);
    }

    /**
     * Display the specified translation
     */
    public function show(Translation $translation): JsonResponse
    {
        return response()->json([
            'translation' => new TranslationResource($translation->load('model'))
        ]);
    }

    /**
     * Update the specified translation
     */
    public function update(Request $request, Translation $translation): JsonResponse
    {
        $request->validate([
            'translated_value' => 'required|string',
        ]);

        $translation->update(['translated_value' => $request->translated_value]);

        return response()->json([
            'message' => 'Translation updated successfully',
            'translation' => new TranslationResource($translation)
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
     * Bulk operations for translations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:translations,id',
            'action' => 'required|in:delete',
        ]);

        if ($request->action === 'delete') {
            Translation::whereIn('id', $request->ids)->delete();
        }

        return response()->json([
            'message' => 'Bulk operation completed successfully'
        ]);
    }

    /**
     * Get translations for a specific model
     */
    public function getModelTranslations(Request $request): JsonResponse
    {
        $request->validate([
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
        ]);

        $translations = Translation::where([
            'model_type' => $request->model_type,
            'model_id' => $request->model_id,
        ])->get();

        return response()->json([
            'translations' => TranslationResource::collection($translations)
        ]);
    }

    /**
     * Dashboard stats
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total_translations' => Translation::count(),
            'pashto_translations' => Translation::where('language', 'pashto')->count(),
            'farsi_translations' => Translation::where('language', 'farsi')->count(),
            'translations_by_model' => Translation::selectRaw('model_type, count(*) as count')
                ->groupBy('model_type')
                ->pluck('count', 'model_type'),
            'recent_translations' => Translation::where('created_at', '>=', now()->subDays(7))->count(),
        ]);
    }

    /**
     * Get supported languages and model types for filtering
     */
    public function getFilters(): JsonResponse
    {
        return response()->json([
            'languages' => ['pashto', 'farsi'],
            'model_types' => Translation::distinct()->pluck('model_type')->values(),
            'field_names' => Translation::distinct()->pluck('field_name')->values(),
        ]);
    }
}
