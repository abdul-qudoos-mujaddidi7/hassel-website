<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\CommunityProgramResource;

class CommunityProgramController extends Controller
{
    /**
     * Get community programs list with filtering and pagination
     */
    public function index(Request $request)
    {
        $targetGroup = $request->get('target_group'); // filter by target group
        $programType = $request->get('program_type'); // filter by program type
        $status = $request->get('status', 'all'); // ongoing, completed, all

        $query = CommunityProgram::published();

        // Apply target group filter if provided
        if ($targetGroup) {
            $query->forTargetGroup($targetGroup);
        }

        // Apply program type filter if provided
        if ($programType) {
            $query->byType($programType);
        }

        // Apply status filter
        switch ($status) {
            case 'ongoing':
                $query->ongoing();
                break;
            case 'completed':
                $query->completed();
                break;
            default:
                // Show all published programs
                break;
        }

        $programs = $query->orderBy('created_at', 'desc')->paginate(12);

        return CommunityProgramResource::collection($programs);
    }

    /**
     * Get single community program details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $program = CommunityProgram::where('slug', $slug)
            ->where('status', 'published')
            ->with('registrations')
            ->firstOrFail();

        // Get related programs (same target group)
        $relatedPrograms = CommunityProgram::published()
            ->where('id', '!=', $program->id)
            ->where('target_group', $program->target_group)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'program' => new CommunityProgramResource($program),
            'related_programs' => CommunityProgramResource::collection($relatedPrograms)
        ]);
    }

    /**
     * Get target groups for filtering
     */
    public function targetGroups(): JsonResponse
    {
        return response()->json([
            'target_groups' => [
                ['value' => 'women', 'label' => 'Women'],
                ['value' => 'youth', 'label' => 'Youth'],
                ['value' => 'cooperatives', 'label' => 'Cooperatives'],
                ['value' => 'farmers', 'label' => 'Farmers'],
                ['value' => 'all', 'label' => 'All Groups'],
            ]
        ]);
    }

    /**
     * Get program types for filtering
     */
    public function types(): JsonResponse
    {
        $types = CommunityProgram::published()
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
