<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\JobAnnouncementResource;

class JobAnnouncementController extends Controller
{
    /**
     * Get job announcements list with pagination and language support
     */
    public function index(Request $request)
    {
        $language = $request->get('lang', 'en');
        $perPage = (int) $request->get('per_page', 9);

        // Optional status filter: open (default) | draft | closed | active (open or draft)
        $status = strtolower((string) $request->get('status', 'open'));

        $query = JobAnnouncement::query();
        if ($status === 'active') {
            $query = $query->whereIn('status', ['open', 'draft']);
        } elseif (in_array($status, ['open', 'draft', 'closed'], true)) {
            $query = $query->where('status', $status);
        } else {
            // default safeguard
            $query = $query->where('status', 'open');
        }

        // Optional ordering
        $orderBy = $request->get('orderBy', 'opened_at');
        $direction = strtolower((string) $request->get('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        // Whitelist orderable columns
        $orderable = ['opened_at', 'created_at', 'title', 'deadline'];
        if (!in_array($orderBy, $orderable, true)) {
            $orderBy = 'opened_at';
        }

        $jobs = $query->orderBy($orderBy, $direction)->paginate($perPage);

        return JobAnnouncementResource::collection($jobs);
    }

    /**
     * Get single job announcement with related jobs
     */
    public function show(string $slug, Request $request)
    {
        $language = $request->get('lang', 'en');
        
        $job = JobAnnouncement::where('slug', $slug)
            ->where('status', 'open')
            ->firstOrFail();

        return new JobAnnouncementResource($job);
    }
}
