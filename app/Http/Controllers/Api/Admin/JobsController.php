<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\JobAnnouncement;
use App\Services\TranslationSyncService;
use App\Http\Requests\JobAnnouncementRequest;
use App\Http\Resources\JobResource;

class JobsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = JobAnnouncement::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('requirements', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => JobResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(JobAnnouncementRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = JobAnnouncement::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => new JobResource($item)], 201);
    }

    public function show(JobAnnouncement $job): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new JobResource($job)]);
    }

    public function update(JobAnnouncementRequest $request, JobAnnouncement $job): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $job->update($validated);
        TranslationSyncService::sync($job, $translations);

        return response()->json(['success' => true, 'data' => new JobResource($job)]);
    }

    public function destroy(JobAnnouncement $job): JsonResponse
    {
        $job->delete();
        return response()->json(['success' => true]);
    }
}
