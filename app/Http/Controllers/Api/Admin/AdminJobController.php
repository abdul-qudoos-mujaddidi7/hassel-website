<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;

class AdminJobController extends Controller
{
    /**
     * Display a listing of job announcements
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $search = $request->get('search');
        $location = $request->get('location');

        $query = JobAnnouncement::query();

        if ($status) {
            $query->where('status', $status);
        }

        if ($location) {
            $query->where('location', 'like', "%{$location}%");
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $jobs = $query->orderBy('deadline', 'asc')
            ->paginate($request->get('per_page', 15));

        return JobResource::collection($jobs);
    }

    /**
     * Store a newly created job announcement
     */
    public function store(JobRequest $request): JsonResponse
    {
        $data = $request->validated();
        $job = JobAnnouncement::create($data);

        return response()->json([
            'message' => 'Job announcement created successfully',
            'job' => new JobResource($job)
        ], 201);
    }

    /**
     * Display the specified job announcement
     */
    public function show(JobAnnouncement $job): JsonResponse
    {
        return response()->json([
            'job' => new JobResource($job)
        ]);
    }

    /**
     * Update the specified job announcement
     */
    public function update(JobRequest $request, JobAnnouncement $job): JsonResponse
    {
        $data = $request->validated();
        $job->update($data);

        return response()->json([
            'message' => 'Job announcement updated successfully',
            'job' => new JobResource($job)
        ]);
    }

    /**
     * Remove the specified job announcement
     */
    public function destroy(JobAnnouncement $job): JsonResponse
    {
        $job->delete();

        return response()->json([
            'message' => 'Job announcement deleted successfully'
        ]);
    }

    /**
     * Bulk operations
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:job_announcements,id',
            'action' => 'required|in:publish,unpublish,archive,delete,close',
        ]);

        $jobs = JobAnnouncement::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $jobs->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $jobs->update(['status' => 'draft']);
                break;
            case 'archive':
                $jobs->update(['status' => 'archived']);
                break;
            case 'close':
                $jobs->update(['deadline' => now()->subDay()]);
                break;
            case 'delete':
                $jobs->delete();
                break;
        }

        return response()->json([
            'message' => ucfirst($request->action) . ' operation completed successfully'
        ]);
    }

    /**
     * Dashboard stats
     */
    public function stats(): JsonResponse
    {
        return response()->json([
            'total_jobs' => JobAnnouncement::count(),
            'open_jobs' => JobAnnouncement::open()->count(),
            'closed_jobs' => JobAnnouncement::closed()->count(),
            'published_jobs' => JobAnnouncement::published()->count(),
        ]);
    }

    /**
     * Get job locations for filtering
     */
    public function locations(): JsonResponse
    {
        $locations = JobAnnouncement::distinct()
            ->pluck('location')
            ->filter()
            ->values();

        return response()->json(['locations' => $locations]);
    }
}
