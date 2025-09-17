<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarketAccessProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MarketAccessProgramController extends Controller
{
    /**
     * Get market access programs list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
        $programType = $request->get('program_type'); // filter by program type
        $crop = $request->get('crop'); // filter by target crop

        $query = MarketAccessProgram::published();

        // Apply program type filter if provided
        if ($programType) {
            $query->byType($programType);
        }

        // Apply crop filter if provided
        if ($crop) {
            $query->byCrop($crop);
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(12);

        // Apply translations if needed
        if ($language !== 'en') {
            $programs->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json($programs);
    }

    /**
     * Get single market access program details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $program = MarketAccessProgram::where('slug', $slug)
            ->where('status', 'published')
            ->with('registrations')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $program->title = $program->getTranslation('title', $language);
            $program->description = $program->getTranslation('description', $language);
        }

        // Add computed properties
        $program->program_type_display = $program->program_type_display;
        $program->target_crops_list = $program->target_crops_list;
        $program->partner_organizations_list = $program->partner_organizations_list;

        return response()->json(['program' => $program]);
    }

    /**
     * Get program types for filtering
     */
    public function types(): JsonResponse
    {
        $types = MarketAccessProgram::published()
            ->distinct()
            ->pluck('program_type')
            ->filter()
            ->values();

        return response()->json([
            'types' => $types->map(function ($type) {
                return [
                    'value' => $type,
                    'label' => ucwords(str_replace('_', ' ', $type))
                ];
            })
        ]);
    }
}
