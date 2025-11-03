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

        // Ensure lang parameter is set for translations
        $lang = $request->get('lang', 'en');
        $request->merge(['lang' => $lang]);

        // Transform each item through the resource
        $data = collect($projects->items())->map(function ($item) use ($request) {
            return (new EnvironmentalProjectResource($item))->resolve($request);
        });

        // Return response in the format expected by frontend
        return response()->json([
            'data' => $data,
            'meta' => [
                'total' => $projects->total(),
                'per_page' => $projects->perPage(),
                'current_page' => $projects->currentPage(),
                'last_page' => $projects->lastPage(),
            ],
            'links' => [
                'first' => $projects->url(1),
                'last' => $projects->url($projects->lastPage()),
                'prev' => $projects->previousPageUrl(),
                'next' => $projects->nextPageUrl(),
            ],
        ]);
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
