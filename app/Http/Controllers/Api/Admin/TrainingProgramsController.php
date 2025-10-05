<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrainingProgramRequest;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\TranslationSyncService;

class TrainingProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 15);
            $search = $request->get('search', '');
            $status = $request->get('status', '');
            $programType = $request->get('program_type', '');

            $query = TrainingProgram::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('instructor', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            if ($programType) {
                $query->where('program_type', $programType);
            }

            $trainingPrograms = $query->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $trainingPrograms->items(),
                'meta' => [
                    'total' => $trainingPrograms->total(),
                    'per_page' => $trainingPrograms->perPage(),
                    'current_page' => $trainingPrograms->currentPage(),
                    'last_page' => $trainingPrograms->lastPage(),
                ],
                'message' => 'Training programs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve training programs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingProgramRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);
            $trainingProgram = TrainingProgram::create($validated);
            TranslationSyncService::sync($trainingProgram, $translations);

            return response()->json([
                'success' => true,
                'data' => $trainingProgram,
                'message' => 'Training program created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingProgram $trainingProgram): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $trainingProgram,
                'message' => 'Training program retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TrainingProgramRequest $request, TrainingProgram $trainingProgram): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);
            $trainingProgram->update($validated);
            TranslationSyncService::sync($trainingProgram, $translations);

            return response()->json([
                'success' => true,
                'data' => $trainingProgram,
                'message' => 'Training program updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingProgram $trainingProgram): JsonResponse
    {
        try {
            $trainingProgram->delete();

            return response()->json([
                'success' => true,
                'message' => 'Training program deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete training program',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get published training programs
     */
    public function published(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);
            $search = $request->get('search', '');

            $query = TrainingProgram::published();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            }

            $trainingPrograms = $query->orderBy('start_date', 'asc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $trainingPrograms->items(),
                'meta' => [
                    'total' => $trainingPrograms->total(),
                    'per_page' => $trainingPrograms->perPage(),
                    'current_page' => $trainingPrograms->currentPage(),
                    'last_page' => $trainingPrograms->lastPage(),
                ],
                'message' => 'Published training programs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve published training programs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get upcoming training programs
     */
    public function upcoming(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);

            $trainingPrograms = TrainingProgram::upcoming()
                ->orderBy('start_date', 'asc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $trainingPrograms->items(),
                'meta' => [
                    'total' => $trainingPrograms->total(),
                    'per_page' => $trainingPrograms->perPage(),
                    'current_page' => $trainingPrograms->currentPage(),
                    'last_page' => $trainingPrograms->lastPage(),
                ],
                'message' => 'Upcoming training programs retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve upcoming training programs',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get program statistics
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = [
                'total' => TrainingProgram::count(),
                'published' => TrainingProgram::published()->count(),
                'upcoming' => TrainingProgram::upcoming()->count(),
                'ongoing' => TrainingProgram::ongoing()->count(),
                'completed' => TrainingProgram::completed()->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Training program statistics retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve training program statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
