<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeedSupplyProgram;
use App\Http\Requests\SeedSupplyProgramRequest;
use App\Http\Resources\SeedSupplyProgramResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class AdminSeedSupplyProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 15);
        $status = $request->get('status');
        $inputType = $request->get('input_type');
        $availability = $request->get('availability');
        $search = $request->get('search');
        $orderBy = $request->get('orderBy', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = SeedSupplyProgram::query();

        // Status filter
        if (!empty($status)) {
            $query->where('status', $status);
        }

        // Input type filter
        if (!empty($inputType)) {
            $query->where('input_type', $inputType);
        }

        // Availability filter
        if (!empty($availability)) {
            $query->where('availability', $availability);
        }

        // Search filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('supplier', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortable = ['created_at', 'updated_at', 'name', 'price_range', 'status', 'availability'];
        if (!in_array($orderBy, $sortable, true)) {
            $orderBy = 'created_at';
        }
        $query->orderBy($orderBy, $direction);

        $programs = $query->paginate($perPage);

        return SeedSupplyProgramResource::collection($programs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeedSupplyProgramRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $program = SeedSupplyProgram::create($data);

        return response()->json([
            'message' => 'Seed supply program created successfully',
            'data' => new SeedSupplyProgramResource($program)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        return response()->json(new SeedSupplyProgramResource($seedSupplyProgram));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SeedSupplyProgramRequest $request, SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        $data = $request->validated();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $seedSupplyProgram->update($data);

        return response()->json([
            'message' => 'Seed supply program updated successfully',
            'data' => new SeedSupplyProgramResource($seedSupplyProgram)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeedSupplyProgram $seedSupplyProgram): JsonResponse
    {
        $seedSupplyProgram->delete();

        return response()->json([
            'message' => 'Seed supply program deleted successfully'
        ]);
    }

    /**
     * Get program statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_programs' => SeedSupplyProgram::count(),
            'published_programs' => SeedSupplyProgram::where('status', 'published')->count(),
            'draft_programs' => SeedSupplyProgram::where('status', 'draft')->count(),
            'ongoing_programs' => SeedSupplyProgram::where('status', 'ongoing')->count(),
            'completed_programs' => SeedSupplyProgram::where('status', 'completed')->count(),
            'cancelled_programs' => SeedSupplyProgram::where('status', 'cancelled')->count(),
            'in_stock' => SeedSupplyProgram::where('availability', 'In Stock')->count(),
            'limited_stock' => SeedSupplyProgram::where('availability', 'Limited')->count(),
            'out_of_stock' => SeedSupplyProgram::where('availability', 'Out of Stock')->count(),
            'coming_soon' => SeedSupplyProgram::where('availability', 'Coming Soon')->count(),
            'input_types' => SeedSupplyProgram::select('input_type')
                ->distinct()
                ->whereNotNull('input_type')
                ->pluck('input_type')
                ->count(),
            'suppliers' => SeedSupplyProgram::select('supplier')
                ->distinct()
                ->whereNotNull('supplier')
                ->pluck('supplier')
                ->count(),
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
            'ids.*' => 'integer|exists:seed_supply_programs,id',
            'status' => 'required|string|in:draft,published,ongoing,completed,cancelled'
        ]);

        $updated = SeedSupplyProgram::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'message' => "Successfully updated {$updated} programs status to {$request->status}"
        ]);
    }

    /**
     * Bulk update availability
     */
    public function bulkUpdateAvailability(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:seed_supply_programs,id',
            'availability' => 'required|string|in:In Stock,Limited,Out of Stock,Coming Soon'
        ]);

        $updated = SeedSupplyProgram::whereIn('id', $request->ids)
            ->update(['availability' => $request->availability]);

        return response()->json([
            'message' => "Successfully updated {$updated} programs availability to {$request->availability}"
        ]);
    }
}
