<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProgramRegistration;
use App\Models\TrainingProgram;
use App\Models\MarketAccessProgram;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProgramRegistrationResource;
use App\Http\Requests\ProgramRegistrationRequest;
use App\Services\EmailService;

class ProgramRegistrationController extends Controller
{
    protected EmailService $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }
    /**
     * Handle program registration
     */
    public function store(ProgramRegistrationRequest $request): JsonResponse
    {
        $registration = ProgramRegistration::create($request->validated());

        // Send email notifications
        $this->emailService->sendProgramRegistrationNotification($registration);
        $this->emailService->sendProgramRegistrationConfirmation($registration);

        return response()->json([
            'message' => 'Registration successful. Your application is pending review.',
            'registration' => new ProgramRegistrationResource($registration)
        ], 201);
    }

    /**
     * Check registration status
     */
    public function status(Request $request, ProgramRegistration $registration): JsonResponse
    {
        return response()->json([
            'registration' => new ProgramRegistrationResource($registration)
        ]);
    }

    /**
     * Get user registrations
     */
    public function userRegistrations(Request $request): JsonResponse
    {
        // In a real app, this would return registrations for the authenticated user
        // For now, returning all for demonstration
        $registrations = ProgramRegistration::orderBy('registration_date', 'desc')
            ->paginate(10);

        return ProgramRegistrationResource::collection($registrations);
    }

    /**
     * Get the program model based on type and ID
     */
    private function getProgramModel(string $programType, int $programId)
    {
        switch ($programType) {
            case 'training_program':
                return TrainingProgram::find($programId);
            case 'market_access_program':
                return MarketAccessProgram::find($programId);
            case 'community_program':
                return CommunityProgram::find($programId);
            default:
                return null;
        }
    }
}
