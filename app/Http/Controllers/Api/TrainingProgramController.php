<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TrainingProgramController extends Controller
{
    /**
     * Get training programs list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
        $status = $request->get('status', 'all'); // all, upcoming, ongoing, completed

        $query = TrainingProgram::published();

        // Apply status filter
        switch ($status) {
            case 'upcoming':
                $query->upcoming();
                break;
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

        $programs = $query->orderBy('start_date', 'asc')->paginate(12);

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
     * Get single training program details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $program = TrainingProgram::where('slug', $slug)
            ->where('status', 'published')
            ->with('registrations')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $program->title = $program->getTranslation('title', $language);
            $program->description = $program->getTranslation('description', $language);
        }

        // Add computed properties
        $program->can_register = $program->canRegister();
        $program->available_spots = $program->available_spots;
        $program->is_full = $program->is_full;
        $program->registration_count = $program->registrations()->where('status', 'approved')->count();

        // Get related programs (same type, excluding current)
        $relatedPrograms = TrainingProgram::published()
            ->where('id', '!=', $program->id)
            ->where('program_type', $program->program_type)
            ->orderBy('start_date', 'asc')
            ->limit(3)
            ->get();

        // Apply translations to related programs
        if ($language !== 'en') {
            $relatedPrograms->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json([
            'program' => $program,
            'related_programs' => $relatedPrograms
        ]);
    }

    /**
     * Get training program types for filtering
     */
    public function types(): JsonResponse
    {
        $types = TrainingProgram::published()
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
