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
        $perPage = $request->get('per_page', 10);
        $status = $request->get('status'); // e.g., 'upcoming', 'ongoing', 'completed'
        $programType = $request->get('program_type');

        $query = TrainingProgram::published()->orderBy('start_date', 'desc');

        if ($status === 'upcoming') {
            $query->upcoming();
        } elseif ($status === 'ongoing') {
            $query->ongoing();
        } elseif ($status === 'completed') {
            $query->completed();
        }

        if ($programType) {
            $query->where('program_type', $programType);
        }

        $programs = $query->paginate($perPage);

        return TrainingProgramResource::collection($programs);
    }

    /**
     * Get single training program details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $program = TrainingProgram::published()->where('slug', $slug)->firstOrFail();

        return response()->json([
            'program' => new TrainingProgramResource($program)
        ]);
    }

    /**
     * Get program types for filtering
     */
    public function types(): JsonResponse
    {
        // This could be dynamic from a lookup table or config
        $types = [
            'basic',
            'advanced',
            'specialized',
            'workshop',
            'field_school'
        ];
        return response()->json(['program_types' => $types]);
    }
}
