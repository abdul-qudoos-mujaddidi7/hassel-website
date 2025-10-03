<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SmartFarmingProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SmartFarmingProgramResource;

class SmartFarmingProgramController extends Controller
{
    /**
     * Get smart farming programs list with filtering and pagination
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $status = $request->get('status');
        $farmingType = $request->get('farming_type', $request->get('type'));
        $targetCrops = $request->get('target_crops', $request->get('crops'));
        $search = $request->get('search');
        $orderBy = $request->get('orderBy', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = SmartFarmingProgram::query();

        // Status filter
        if ($status === 'published') {
            $query->where('status', 'published');
        } elseif ($status === 'available') {
            $query->published()->available();
        } else {
            // Default: show only published programs
            $query->where('status', 'published');
        }

        // Farming type filter
        if (!empty($farmingType)) {
            $query->where('farming_type', $farmingType);
        }

        // Target crops filter
        if (!empty($targetCrops)) {
            $query->byTargetCrops($targetCrops);
        }

        // Search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting with whitelist fallback
        $sortable = ['created_at', 'updated_at', 'name', 'sustainability_level'];
        if (!in_array($orderBy, $sortable, true)) {
            $orderBy = 'created_at';
        }
        $query->orderBy($orderBy, $direction);

        $programs = $query->paginate($perPage);

        return SmartFarmingProgramResource::collection($programs);
    }

    /**
     * Get single smart farming program details
     */
    public function show(string $slugOrId, Request $request): JsonResponse
    {
        $program = SmartFarmingProgram::published()
            ->where('slug', $slugOrId)
            ->orWhere(function ($q) use ($slugOrId) {
                if (is_numeric($slugOrId)) {
                    $q->where('id', (int) $slugOrId);
                }
            })
            ->firstOrFail();

        return response()->json(new SmartFarmingProgramResource($program));
    }

    /**
     * Get farming types for filtering
     */
    public function types(): JsonResponse
    {
        $types = SmartFarmingProgram::where('status', 'published')
            ->select('farming_type')
            ->distinct()
            ->whereNotNull('farming_type')
            ->where('farming_type', '!=', '')
            ->pluck('farming_type')
            ->sort()
            ->values()
            ->toArray();

        return response()->json(['farming_types' => $types]);
    }

    /**
     * Get target crops for filtering
     */
    public function crops(): JsonResponse
    {
        $crops = SmartFarmingProgram::where('status', 'published')
            ->whereNotNull('target_crops')
            ->get()
            ->pluck('target_crops')
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->toArray();

        return response()->json(['target_crops' => $crops]);
    }
}
