<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TrainingProgramResource;

class TrainingProgramController extends Controller
{
    /**
     * Get training programs list with filtering and pagination
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);
        $status = $request->get('status'); // upcoming | ongoing | completed
        $type = $request->get('type', $request->get('program_type'));
        $location = $request->get('location');
        $orderBy = $request->get('orderBy', 'created_at');
        $direction = strtolower($request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        $query = TrainingProgram::query();

        // Status filter using actual enum values
        if ($status === 'published') {
            $query->where('status', 'published');
        } elseif ($status === 'upcoming') {
            $query->where('start_date', '>', now())->where('status', 'published');
        } elseif ($status === 'ongoing') {
            $query->where('status', 'ongoing');
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } elseif ($status === 'cancelled') {
            $query->where('status', 'cancelled');
        } else {
            // Default: show only published programs
            $query->where('status', 'published');
        }

        // Type filter
        if (!empty($type)) {
            $query->where('program_type', $type);
        }

        // Location filter (case-insensitive)
        if (!empty($location)) {
            $like = "%" . strtolower($location) . "%";
            $query->whereRaw('LOWER(location) LIKE ?', [$like]);
        }

        // Sorting with whitelist fallback
        $sortable = ['created_at', 'updated_at', 'start_date', 'end_date', 'title'];
        if (!in_array($orderBy, $sortable, true)) {
            $orderBy = 'created_at';
        }
        $query->orderBy($orderBy, $direction);

        $programs = $query->paginate($perPage);

        return TrainingProgramResource::collection($programs);
    }

    /**
     * Get single training program details
     */
    public function show(string $slugOrId, Request $request): JsonResponse
    {
        $program = TrainingProgram::published()
            ->where('slug', $slugOrId)
            ->orWhere(function ($q) use ($slugOrId) {
                if (is_numeric($slugOrId)) {
                    $q->where('id', (int) $slugOrId);
                }
            })
            ->firstOrFail();

        return response()->json(new TrainingProgramResource($program));
    }

    /**
     * Get program types for filtering
     */
    public function types(): JsonResponse
    {
        $types = TrainingProgram::where('status', 'published')
            ->select('program_type')
            ->distinct()
            ->whereNotNull('program_type')
            ->where('program_type', '!=', '')
            ->pluck('program_type')
            ->sort()
            ->values()
            ->toArray();

        return response()->json(['program_types' => $types]);
    }
}
