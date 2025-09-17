<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgramRegistration;
use App\Models\TrainingProgram;
use App\Models\MarketAccessProgram;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ProgramRegistrationController extends Controller
{
    /**
     * Handle program registration
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'program_type' => 'required|in:training_program,market_access_program,community_program',
            'program_id' => 'required|integer|exists:' . $this->getProgramTable($request->program_type) . ',id',
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        // Check if user already registered for this program
        $existingRegistration = ProgramRegistration::where('program_type', $request->program_type)
            ->where('program_id', $request->program_id)
            ->where('email', $request->email)
            ->first();

        if ($existingRegistration) {
            throw ValidationException::withMessages([
                'email' => ['You have already registered for this program.']
            ]);
        }

        // Get program and check if registration is allowed
        $program = $this->getProgramModel($request->program_type, $request->program_id);

        // Special validation for training programs
        if ($request->program_type === 'training_program' && !$program->canRegister()) {
            throw ValidationException::withMessages([
                'program_id' => ['Registration is not available for this program. It may be full, expired, or not accepting registrations.']
            ]);
        }

        // Create registration
        $registration = ProgramRegistration::create([
            'program_type' => $request->program_type,
            'program_id' => $request->program_id,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'registration_date' => now(),
            'status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Registration submitted successfully. You will receive a confirmation email shortly.',
            'registration' => [
                'id' => $registration->id,
                'program_type' => $registration->program_type_display,
                'program_title' => $program->title,
                'status' => $registration->status_display,
                'registration_date' => $registration->formatted_registration_date
            ]
        ], 201);
    }

    /**
     * Get registration status by email and program
     */
    public function status(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'program_type' => 'required|in:training_program,market_access_program,community_program',
            'program_id' => 'required|integer'
        ]);

        $registration = ProgramRegistration::where('email', $request->email)
            ->where('program_type', $request->program_type)
            ->where('program_id', $request->program_id)
            ->first();

        if (!$registration) {
            return response()->json([
                'message' => 'No registration found for this email and program.'
            ], 404);
        }

        $program = $this->getProgramModel($request->program_type, $request->program_id);

        return response()->json([
            'registration' => [
                'id' => $registration->id,
                'status' => $registration->status,
                'status_display' => $registration->status_display,
                'registration_date' => $registration->formatted_registration_date,
                'program' => [
                    'title' => $program->title,
                    'type' => $registration->program_type_display
                ]
            ]
        ]);
    }

    /**
     * Get user's all registrations by email
     */
    public function userRegistrations(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $registrations = ProgramRegistration::where('email', $request->email)
            ->orderBy('registration_date', 'desc')
            ->get();

        $registrations->transform(function ($registration) {
            $program = $registration->getProgramInstance();

            return [
                'id' => $registration->id,
                'program_type' => $registration->program_type,
                'program_type_display' => $registration->program_type_display,
                'program_title' => $program ? $program->title : 'Program Not Found',
                'status' => $registration->status,
                'status_display' => $registration->status_display,
                'registration_date' => $registration->formatted_registration_date
            ];
        });

        return response()->json([
            'registrations' => $registrations
        ]);
    }

    /**
     * Helper method to get program table name
     */
    private function getProgramTable(string $programType): string
    {
        return match ($programType) {
            'training_program' => 'training_programs',
            'market_access_program' => 'market_access_programs',
            'community_program' => 'community_programs',
            default => throw new \InvalidArgumentException('Invalid program type')
        };
    }

    /**
     * Helper method to get program model instance
     */
    private function getProgramModel(string $programType, int $programId)
    {
        return match ($programType) {
            'training_program' => TrainingProgram::findOrFail($programId),
            'market_access_program' => MarketAccessProgram::findOrFail($programId),
            'community_program' => CommunityProgram::findOrFail($programId),
            default => throw new \InvalidArgumentException('Invalid program type')
        };
    }
}
