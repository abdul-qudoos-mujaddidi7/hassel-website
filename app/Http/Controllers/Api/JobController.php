<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\JobResource;

class JobController extends Controller
{
    /**
     * Get job announcements list with filtering
     */
    public function index(Request $request): JsonResponse
    {
        $status = $request->get('status', 'open'); // open, closed, all
        $location = $request->get('location'); // filter by location

        $query = JobAnnouncement::published();

        // Apply status filter
        switch ($status) {
            case 'open':
                $query->open();
                break;
            case 'closed':
                $query->closed();
                break;
            default:
                // Show all published jobs
                break;
        }

        // Apply location filter if provided
        if ($location) {
            $query->where('location', 'like', '%' . $location . '%');
        }

        $jobs = $query->orderBy('deadline', 'asc')->paginate(12);

        return JobResource::collection($jobs);
    }

    /**
     * Get single job announcement details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $job = JobAnnouncement::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related jobs (same location or similar)
        $relatedJobs = JobAnnouncement::open()
            ->where('id', '!=', $job->id)
            ->where(function ($query) use ($job) {
                $query->where('location', $job->location)
                    ->orWhere('location', 'like', '%' . $job->location . '%');
            })
            ->orderBy('deadline', 'asc')
            ->limit(3)
            ->get();

        return response()->json([
            'job' => new JobResource($job),
            'related_jobs' => JobResource::collection($relatedJobs)
        ]);
    }

    /**
     * Get available job locations for filtering
     */
    public function locations(): JsonResponse
    {
        $locations = JobAnnouncement::open()
            ->distinct()
            ->pluck('location')
            ->filter()
            ->values();

        return response()->json(['locations' => $locations]);
    }
}
