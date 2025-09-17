<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JobController extends Controller
{
    /**
     * Get job announcements list with filtering
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
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

        // Apply translations if needed
        if ($language !== 'en') {
            $jobs->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                $item->requirements = $item->getTranslation('requirements', $language);
                return $item;
            });
        }

        return response()->json($jobs);
    }

    /**
     * Get single job announcement details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $job = JobAnnouncement::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $job->title = $job->getTranslation('title', $language);
            $job->description = $job->getTranslation('description', $language);
            $job->requirements = $job->getTranslation('requirements', $language);
        }

        // Add computed properties
        $job->is_open = $job->is_open;
        $job->is_expired = $job->is_expired;
        $job->days_remaining = $job->days_remaining;
        $job->requirements_list = $job->requirements_list;

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
            'job' => $job,
            'related_jobs' => $relatedJobs
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
