<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminTrainingProgramController extends Controller
{
    /**
     * Display a listing of training programs
     */
    public function index(Request $request): JsonResponse
    {
        $query = TrainingProgram::with('registrations');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('program_type')) {
            $query->where('program_type', $request->program_type);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('instructor', 'like', '%' . $request->search . '%');
            });
        }

        $programs = $query->orderBy('start_date', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($programs);
    }

    /**
     * Store a newly created training program
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:training_programs,slug|max:255',
            'description' => 'required|string',
            'program_type' => 'required|in:basic,advanced,specialized,workshop,field_school',
            'duration' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1|max:1000',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $program = TrainingProgram::create($data);

        return response()->json([
            'message' => 'Training program created successfully',
            'program' => $program
        ], 201);
    }

    /**
     * Display the specified training program
     */
    public function show(TrainingProgram $trainingProgram): JsonResponse
    {
        return response()->json([
            'program' => $trainingProgram->load('registrations')
        ]);
    }

    /**
     * Update the specified training program
     */
    public function update(Request $request, TrainingProgram $trainingProgram): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:training_programs,slug,' . $trainingProgram->id . '|max:255',
            'description' => 'required|string',
            'program_type' => 'required|in:basic,advanced,specialized,workshop,field_school',
            'duration' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        // Handle slug generation
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $trainingProgram->update($data);

        return response()->json([
            'message' => 'Training program updated successfully',
            'program' => $trainingProgram->fresh()
        ]);
    }

    /**
     * Remove the specified training program
     */
    public function destroy(TrainingProgram $trainingProgram): JsonResponse
    {
        // Delete associated translations and registrations
        $trainingProgram->translations()->delete();
        $trainingProgram->registrations()->delete();
        $trainingProgram->delete();

        return response()->json([
            'message' => 'Training program deleted successfully'
        ]);
    }

    /**
     * Get program registrations
     */
    public function registrations(TrainingProgram $trainingProgram): JsonResponse
    {
        $registrations = $trainingProgram->registrations()
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($registrations);
    }

    /**
     * Get program statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => TrainingProgram::count(),
            'upcoming' => TrainingProgram::upcoming()->count(),
            'ongoing' => TrainingProgram::ongoing()->count(),
            'completed' => TrainingProgram::completed()->count(),
            'by_type' => TrainingProgram::selectRaw('program_type, count(*) as count')
                ->groupBy('program_type')
                ->get()
                ->pluck('count', 'program_type'),
        ]);
    }
}
