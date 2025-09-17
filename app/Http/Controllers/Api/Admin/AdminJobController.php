<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminJobController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = JobAnnouncement::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $jobs = $query->orderBy('deadline', 'desc')->paginate(15);
        return response()->json($jobs);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:job_announcements,slug|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $job = JobAnnouncement::create($data);

        return response()->json(['message' => 'Job created', 'job' => $job], 201);
    }

    public function show(JobAnnouncement $jobAnnouncement): JsonResponse
    {
        return response()->json(['job' => $jobAnnouncement]);
    }

    public function update(Request $request, JobAnnouncement $jobAnnouncement): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:job_announcements,slug,' . $jobAnnouncement->id,
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'deadline' => 'required|date',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $jobAnnouncement->update($data);

        return response()->json(['message' => 'Job updated', 'job' => $jobAnnouncement->fresh()]);
    }

    public function destroy(JobAnnouncement $jobAnnouncement): JsonResponse
    {
        $jobAnnouncement->translations()->delete();
        $jobAnnouncement->delete();

        return response()->json(['message' => 'Job deleted']);
    }
}
