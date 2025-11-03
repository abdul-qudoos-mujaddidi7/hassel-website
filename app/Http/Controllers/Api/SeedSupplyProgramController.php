<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SeedSupplyProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SeedSupplyProgramResource;

class SeedSupplyProgramController extends Controller
{
    /**
     * Get seed supply programs list with filtering and pagination
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $status = $request->get('status');
        $inputType = $request->get('input_type', $request->get('type'));
        $targetCrops = $request->get('target_crops', $request->get('crops'));
        $availability = $request->get('availability');
        $search = $request->get('search');
        $orderBy = $request->get('orderBy', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = SeedSupplyProgram::query();

        // Status filter
        if ($status === 'published') {
            $query->where('status', 'published');
        } elseif ($status === 'available') {
            $query->published()->available();
        } else {
            // Default: show only published programs
            $query->where('status', 'published');
        }

        // Input type filter
        if (!empty($inputType)) {
            $query->where('input_type', $inputType);
        }

        // Target crops filter
        if (!empty($targetCrops)) {
            $query->byTargetCrops($targetCrops);
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
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Sorting with whitelist fallback
        $sortable = ['created_at', 'updated_at', 'name', 'price_range'];
        if (!in_array($orderBy, $sortable, true)) {
            $orderBy = 'created_at';
        }
        $query->orderBy($orderBy, $direction);

        $programs = $query->paginate($perPage);

        // Ensure lang parameter is set for translations
        $lang = $request->get('lang', 'en');
        $request->merge(['lang' => $lang]);

        // Transform each item through the resource
        $data = collect($programs->items())->map(function ($item) use ($request) {
            return (new SeedSupplyProgramResource($item))->resolve($request);
        });

        // Return response in the format expected by frontend
        return response()->json([
            'data' => $data,
            'meta' => [
                'total' => $programs->total(),
                'per_page' => $programs->perPage(),
                'current_page' => $programs->currentPage(),
                'last_page' => $programs->lastPage(),
            ],
            'links' => [
                'first' => $programs->url(1),
                'last' => $programs->url($programs->lastPage()),
                'prev' => $programs->previousPageUrl(),
                'next' => $programs->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Get single seed supply program details
     */
    public function show(string $slugOrId, Request $request): JsonResponse
    {
        $program = SeedSupplyProgram::published()
            ->where('slug', $slugOrId)
            ->orWhere(function ($q) use ($slugOrId) {
                if (is_numeric($slugOrId)) {
                    $q->where('id', (int) $slugOrId);
                }
            })
            ->firstOrFail();

        return response()->json(new SeedSupplyProgramResource($program));
    }

    /**
     * Get input types for filtering
     */
    public function types(): JsonResponse
    {
        $types = SeedSupplyProgram::where('status', 'published')
            ->select('input_type')
            ->distinct()
            ->whereNotNull('input_type')
            ->where('input_type', '!=', '')
            ->pluck('input_type')
            ->sort()
            ->values()
            ->toArray();

        return response()->json(['input_types' => $types]);
    }

    /**
     * Get target crops for filtering
     */
    public function crops(): JsonResponse
    {
        $crops = SeedSupplyProgram::where('status', 'published')
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

    /**
     * Get availability statuses for filtering
     */
    public function availability(): JsonResponse
    {
        $availability = SeedSupplyProgram::where('status', 'published')
            ->select('availability')
            ->distinct()
            ->whereNotNull('availability')
            ->where('availability', '!=', '')
            ->pluck('availability')
            ->sort()
            ->values()
            ->toArray();

        return response()->json(['availability_statuses' => $availability]);
    }
}
