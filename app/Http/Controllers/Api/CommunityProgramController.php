<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommunityProgramController extends Controller
{
    /**
     * Get community programs list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
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
     * Get single community program details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $program = CommunityProgram::where('slug', $slug)
            ->where('status', 'published')
            ->with('registrations')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $program->title = $program->getTranslation('title', $language);
            $program->description = $program->getTranslation('description', $language);
        }

        // Add computed properties
        $program->target_group_display = $program->target_group_display;
        $program->program_type_display = $program->program_type_display;
        $program->partner_organizations_list = $program->partner_organizations_list;

        // Get related programs (same target group)
        $relatedPrograms = CommunityProgram::published()
            ->where('id', '!=', $program->id)
            ->where('target_group', $program->target_group)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'program' => $program,
            'related_programs' => $relatedPrograms
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
