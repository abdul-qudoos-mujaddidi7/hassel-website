<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramRegistration;
use App\Models\TrainingProgram;
use App\Models\MarketAccessProgram;
use App\Models\CommunityProgram;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AdminProgramRegistrationController extends Controller
{
    /**
     * Display a listing of program registrations
     */
    public function index(Request $request): JsonResponse
    {
        $query = ProgramRegistration::with('program');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('program_type')) {
            $query->where('program_type', $request->program_type);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('user_name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('date_from')) {
            $query->whereDate('registration_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('registration_date', '<=', $request->date_to);
        }

        $registrations = $query->orderBy('registration_date', 'desc')
            ->paginate($request->get('per_page', 15));

        // Add program details to each registration
        $registrations->getCollection()->transform(function ($registration) {
            $programModel = $this->getProgramModel($registration->program_type, $registration->program_id);
            $registration->program_details = $programModel ? [
                'title' => $programModel->title,
                'slug' => $programModel->slug,
            ] : null;
            return $registration;
        });

        return response()->json($registrations);
    }

    /**
     * Display the specified registration
     */
    public function show(ProgramRegistration $programRegistration): JsonResponse
    {
        $programModel = $this->getProgramModel($programRegistration->program_type, $programRegistration->program_id);
        $programRegistration->program_details = $programModel;

        return response()->json(['registration' => $programRegistration]);
    }

    /**
     * Update the registration status
     */
    public function updateStatus(Request $request, ProgramRegistration $programRegistration): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $programRegistration->update([
            'status' => $request->status,
            'notes' => $request->notes,
            'updated_at' => now(),
        ]);

        // In a real application, you might send notification emails here

        return response()->json([
            'message' => 'Registration status updated successfully',
            'registration' => $programRegistration->fresh()
        ]);
    }

    /**
     * Remove the specified registration
     */
    public function destroy(ProgramRegistration $programRegistration): JsonResponse
    {
        $programRegistration->delete();

        return response()->json([
            'message' => 'Registration deleted successfully'
        ]);
    }

    /**
     * Bulk update registration status
     */
    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:program_registrations,id',
            'status' => 'required|in:pending,approved,rejected,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $count = ProgramRegistration::whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json([
            'message' => "{$count} registrations updated successfully"
        ]);
    }

    /**
     * Get registration statistics
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => ProgramRegistration::count(),
            'pending' => ProgramRegistration::where('status', 'pending')->count(),
            'approved' => ProgramRegistration::where('status', 'approved')->count(),
            'rejected' => ProgramRegistration::where('status', 'rejected')->count(),
            'cancelled' => ProgramRegistration::where('status', 'cancelled')->count(),
            'by_program_type' => ProgramRegistration::selectRaw('program_type, count(*) as count')
                ->groupBy('program_type')
                ->get()
                ->pluck('count', 'program_type'),
            'this_month' => ProgramRegistration::whereMonth('registration_date', now()->month)
                ->whereYear('registration_date', now()->year)
                ->count(),
        ]);
    }

    /**
     * Export registrations to CSV
     */
    public function export(Request $request): JsonResponse
    {
        $query = ProgramRegistration::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('program_type')) {
            $query->where('program_type', $request->program_type);
        }

        if ($request->has('date_from')) {
            $query->whereDate('registration_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('registration_date', '<=', $request->date_to);
        }

        $registrations = $query->orderBy('registration_date', 'desc')->get();

        // In a real implementation, you would generate and return a CSV file
        return response()->json([
            'message' => 'Export data prepared',
            'count' => $registrations->count(),
            'data' => $registrations->map(function ($registration) {
                $programModel = $this->getProgramModel($registration->program_type, $registration->program_id);
                return [
                    'user_name' => $registration->user_name,
                    'email' => $registration->email,
                    'phone' => $registration->phone,
                    'location' => $registration->location,
                    'program_type' => $registration->program_type,
                    'program_title' => $programModel ? $programModel->title : 'N/A',
                    'status' => $registration->status,
                    'registration_date' => $registration->registration_date->format('Y-m-d H:i:s'),
                ];
            })
        ]);
    }

    /**
     * Get program model by type and ID
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
