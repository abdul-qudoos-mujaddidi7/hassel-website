<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmartFarmingProgram;
use App\Http\Requests\SmartFarmingProgramRequest;
use App\Http\Resources\SmartFarmingProgramResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AdminSmartFarmingProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $status = $request->get('status');
        $farmingType = $request->get('farming_type');
        $search = $request->get('search');
        $orderBy = $request->get('orderBy', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = SmartFarmingProgram::query();

        // Status filter
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Farming type filter
        if (!empty($farmingType)) {
            $query->where('farming_type', $farmingType);
        }

        // Search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortable = ['created_at', 'updated_at', 'name', 'sustainability_level', 'status'];
        if (!in_array($orderBy, $sortable, true)) {
            $orderBy = 'created_at';
        }
        $query->orderBy($orderBy, $direction);

        $programs = $query->paginate($perPage);

        return SmartFarmingProgramResource::collection($programs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SmartFarmingProgramRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $program = SmartFarmingProgram::create($data);

        return response()->json([
            'message' => 'Smart farming program created successfully',
            'data' => new SmartFarmingProgramResource($program)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        return response()->json(new SmartFarmingProgramResource($smartFarmingProgram));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SmartFarmingProgramRequest $request, SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $smartFarmingProgram->update($data);

        return response()->json([
            'message' => 'Smart farming program updated successfully',
            'data' => new SmartFarmingProgramResource($smartFarmingProgram)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SmartFarmingProgram $smartFarmingProgram): JsonResponse
    {
        $smartFarmingProgram->delete();

        return response()->json([
            'message' => 'Smart farming program deleted successfully'
        ]);
    }

    /**
     * Get program statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_programs' => SmartFarmingProgram::count(),
            'published_programs' => SmartFarmingProgram::where('status', 'published')->count(),
            'draft_programs' => SmartFarmingProgram::where('status', 'draft')->count(),
            'ongoing_programs' => SmartFarmingProgram::where('status', 'ongoing')->count(),
            'completed_programs' => SmartFarmingProgram::where('status', 'completed')->count(),
            'cancelled_programs' => SmartFarmingProgram::where('status', 'cancelled')->count(),
            'farming_types' => SmartFarmingProgram::select('farming_type')
                ->distinct()
                ->whereNotNull('farming_type')
                ->pluck('farming_type')
                ->count(),
            'average_sustainability' => SmartFarmingProgram::whereNotNull('sustainability_level')
                ->avg('sustainability_level'),
        ];

        return response()->json($stats);
    }

    /**
     * Bulk update status
     */
    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:smart_farming_programs,id',
            'status' => 'required|string|in:draft,published,ongoing,completed,cancelled'
        ]);

        $updated = SmartFarmingProgram::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'message' => "Successfully updated {$updated} programs status to {$request->status}"
        ]);
    }
}
