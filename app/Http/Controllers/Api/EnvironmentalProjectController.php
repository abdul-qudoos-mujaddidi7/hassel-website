<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalProject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\EnvironmentalProjectResource;

class EnvironmentalProjectController extends Controller
{
    /**
     * Get environmental projects list with filtering and pagination
     */
    public function index(Request $request)
    {
        $projectType = $request->get('project_type'); // filter by project type
        $status = $request->get('status', 'all'); // ongoing, completed, all

        $query = EnvironmentalProject::published();

        // Apply project type filter if provided
        if ($projectType) {
            $query->byType($projectType);
        }

        // Apply status filter
        switch ($status) {
            case 'ongoing':
                $query->ongoing();
                break;
            case 'completed':
                $query->completed();
                break;
            default:
                // Show all published projects
                break;
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(12);

        return EnvironmentalProjectResource::collection($projects);
    }

    /**
     * Get single environmental project details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $project = EnvironmentalProject::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Get related projects (same type)
        $relatedProjects = EnvironmentalProject::published()
            ->where('id', '!=', $project->id)
            ->where('project_type', $project->project_type)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'project' => new EnvironmentalProjectResource($project),
            'related_projects' => EnvironmentalProjectResource::collection($relatedProjects)
        ]);
    }

    /**
     * Get project types for filtering
     */
    public function types(): JsonResponse
    {
        $types = EnvironmentalProject::published()
            ->distinct()
            ->pluck('project_type')
            ->filter()
            ->values();

        return response()->json([
            'types' => $types->map(function ($type) {
                return [
                    'value' => $type,
                    'label' => ucwords(str_replace('_', ' ', $type))
                ];
            })
        ]);
    }
}
