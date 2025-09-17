<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalProject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EnvironmentalProjectRequest;
use App\Http\Resources\EnvironmentalProjectResource;

class AdminEnvironmentalProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = EnvironmentalProject::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->project_type) {
            $query->where('project_type', $request->project_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%")
                    ->orWhere('location', 'like', "%{$request->search}%");
            });
        }

        $projects = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return EnvironmentalProjectResource::collection($projects);
    }

    public function store(EnvironmentalProjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('environmental-projects', 'public');
        }

        $project = EnvironmentalProject::create($data);

        return response()->json([
            'message' => 'Environmental project created successfully',
            'project' => new EnvironmentalProjectResource($project)
        ], 201);
    }

    public function show(EnvironmentalProject $environmentalProject): JsonResponse
    {
        return response()->json([
            'project' => new EnvironmentalProjectResource($environmentalProject)
        ]);
    }

    public function update(EnvironmentalProjectRequest $request, EnvironmentalProject $environmentalProject): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($environmentalProject->featured_image) {
                Storage::disk('public')->delete($environmentalProject->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('environmental-projects', 'public');
        }

        $environmentalProject->update($data);

        return response()->json([
            'message' => 'Environmental project updated successfully',
            'project' => new EnvironmentalProjectResource($environmentalProject)
        ]);
    }

    public function destroy(EnvironmentalProject $environmentalProject): JsonResponse
    {
        if ($environmentalProject->featured_image) {
            Storage::disk('public')->delete($environmentalProject->featured_image);
        }

        $environmentalProject->delete();

        return response()->json(['message' => 'Environmental project deleted successfully']);
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:environmental_projects,id',
            'action' => 'required|in:publish,unpublish,archive,delete,mark_completed',
        ]);

        $projects = EnvironmentalProject::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $projects->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $projects->update(['status' => 'draft']);
                break;
            case 'archive':
                $projects->update(['status' => 'archived']);
                break;
            case 'mark_completed':
                $projects->update(['end_date' => now()]);
                break;
            case 'delete':
                foreach ($projects->get() as $project) {
                    $this->destroy($project);
                }
                break;
        }

        return response()->json(['message' => ucfirst($request->action) . ' operation completed successfully']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total_projects' => EnvironmentalProject::count(),
            'ongoing_projects' => EnvironmentalProject::ongoing()->count(),
            'completed_projects' => EnvironmentalProject::completed()->count(),
            'published_projects' => EnvironmentalProject::published()->count(),
        ]);
    }
}
