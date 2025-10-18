<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobAnnouncementRequest;
use App\Models\JobAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\JobAnnouncementResource;

class JobAnnouncementController extends Controller
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

            $query = JobAnnouncement::query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            $jobs = $query->orderBy('created_at', 'desc')->paginate($perPage);

            // Always include translations for admin routes; pass through lang
            $request->merge([
                'include_translations' => true,
                'lang' => $request->get('lang', 'en'),
            ]);

            // Map each item through resource with current request (so lang applies)
            $data = collect($jobs->items())->map(function ($item) use ($request) {
                return (new JobAnnouncementResource($item))->resolve($request);
            });

            return response()->json([
                'success' => true,
                'data' => $data,
                'meta' => [
                    'total' => $jobs->total(),
                    'per_page' => $jobs->perPage(),
                    'current_page' => $jobs->currentPage(),
                    'last_page' => $jobs->lastPage(),
                ],
                'message' => 'Job announcements retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve job announcements',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobAnnouncementRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Prepare JSON translations
            $farsiTranslations = $translations['farsi'] ?? [];
            $pashtoTranslations = $translations['pashto'] ?? [];
            
            // Add translations to validated data
            $validated['farsi_translations'] = $farsiTranslations;
            $validated['pashto_translations'] = $pashtoTranslations;

            $job = JobAnnouncement::create($validated);

            return response()->json([
                'success' => true,
                'data' => $job,
                'message' => 'Job announcement created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create job announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, JobAnnouncement $jobAnnouncement): JsonResponse
    {
        try {
            // Always include translations for admin routes
            $request->merge(['include_translations' => true]);

            return response()->json([
                'success' => true,
                'data' => (new JobAnnouncementResource($jobAnnouncement))->resolve($request),
                'message' => 'Job announcement retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve job announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobAnnouncementRequest $request, JobAnnouncement $jobAnnouncement): JsonResponse
    {
        try {
            $validated = $request->validated();
            $translations = $request->input('translations', []);

            // Prepare JSON translations
            $farsiTranslations = $translations['farsi'] ?? [];
            $pashtoTranslations = $translations['pashto'] ?? [];
            
            // Add translations to validated data
            $validated['farsi_translations'] = $farsiTranslations;
            $validated['pashto_translations'] = $pashtoTranslations;

            $jobAnnouncement->update($validated);

            return response()->json([
                'success' => true,
                'data' => $jobAnnouncement,
                'message' => 'Job announcement updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update job announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobAnnouncement $jobAnnouncement): JsonResponse
    {
        try {
            $jobAnnouncement->delete();

            return response()->json([
                'success' => true,
                'message' => 'Job announcement deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete job announcement',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get published job announcements
     */
    public function published(Request $request): JsonResponse
    {
        try {
            $perPage = $request->get('perPage', 10);
            $search = $request->get('search', '');

            $query = JobAnnouncement::where('status', 'open');

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            }

            $jobs = $query->orderBy('opened_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $jobs->items(),
                'meta' => [
                    'total' => $jobs->total(),
                    'per_page' => $jobs->perPage(),
                    'current_page' => $jobs->currentPage(),
                    'last_page' => $jobs->lastPage(),
                ],
                'message' => 'Published job announcements retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve published job announcements',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle publish status
     */
    public function toggleStatus(JobAnnouncement $jobAnnouncement): JsonResponse
    {
        try {
            $newStatus = $jobAnnouncement->status === 'open' ? 'draft' : 'open';
            $jobAnnouncement->update([
                'status' => $newStatus,
                'opened_at' => $newStatus === 'open' ? now() : null
            ]);

            return response()->json([
                'success' => true,
                'data' => $jobAnnouncement,
                'message' => "Job announcement {$newStatus} successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to toggle job announcement status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
