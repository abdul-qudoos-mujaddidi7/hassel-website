<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProgramRegistrationResource;

class AdminProgramRegistrationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = ProgramRegistration::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->program_type) {
            $query->where('program_type', $request->program_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('user_name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        $registrations = $query->with(['program'])
            ->orderBy('registration_date', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json(ProgramRegistrationResource::collection($registrations));
    }

    public function show(ProgramRegistration $programRegistration): JsonResponse
    {
        return response()->json([
            'registration' => new ProgramRegistrationResource($programRegistration->load('program'))
        ]);
    }

    public function updateStatus(Request $request, ProgramRegistration $programRegistration): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $programRegistration->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes
        ]);

        return response()->json([
            'message' => 'Registration status updated successfully',
            'registration' => new ProgramRegistrationResource($programRegistration)
        ]);
    }

    public function destroy(ProgramRegistration $programRegistration): JsonResponse
    {
        $programRegistration->delete();

        return response()->json([
            'message' => 'Registration deleted successfully'
        ]);
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:program_registrations,id',
            'action' => 'required|in:approve,reject,mark_completed,delete',
        ]);

        $registrations = ProgramRegistration::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'approve':
                $registrations->update(['status' => 'approved']);
                break;
            case 'reject':
                $registrations->update(['status' => 'rejected']);
                break;
            case 'mark_completed':
                $registrations->update(['status' => 'completed']);
                break;
            case 'delete':
                $registrations->delete();
                break;
        }

        return response()->json([
            'message' => ucfirst($request->action) . ' operation completed successfully'
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total_registrations' => ProgramRegistration::count(),
            'pending_registrations' => ProgramRegistration::where('status', 'pending')->count(),
            'approved_registrations' => ProgramRegistration::where('status', 'approved')->count(),
            'rejected_registrations' => ProgramRegistration::where('status', 'rejected')->count(),
            'completed_registrations' => ProgramRegistration::where('status', 'completed')->count(),
            'recent_registrations' => ProgramRegistration::where('registration_date', '>=', now()->subDays(7))->count(),
            'registrations_by_program_type' => ProgramRegistration::selectRaw('program_type, count(*) as count')
                ->groupBy('program_type')
                ->pluck('count', 'program_type'),
        ]);
    }

    public function export(Request $request): JsonResponse
    {
        $format = $request->get('format', 'csv');

        $registrations = ProgramRegistration::with('program')
            ->select(['user_name', 'email', 'phone', 'location', 'program_type', 'status', 'registration_date'])
            ->orderBy('registration_date', 'desc')
            ->get();

        return response()->json([
            'message' => 'Export ready',
            'format' => $format,
            'count' => $registrations->count(),
            'data' => $registrations
        ]);
    }
}
