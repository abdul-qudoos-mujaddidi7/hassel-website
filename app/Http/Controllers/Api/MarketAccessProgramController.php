<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MarketAccessProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\MarketAccessProgramResource;

class MarketAccessProgramController extends Controller
{
    /**
     * Get market access programs list with filtering and pagination
     */
    public function index(Request $request)
    {
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

        return MarketAccessProgramResource::collection($programs);
    }

    /**
     * Get single market access program details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $program = MarketAccessProgram::where('slug', $slug)
            ->where('status', 'published')
            ->with('registrations')
            ->firstOrFail();

        return response()->json(['program' => new MarketAccessProgramResource($program)]);
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
