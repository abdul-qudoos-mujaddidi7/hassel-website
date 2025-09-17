<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalProject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EnvironmentalProjectController extends Controller
{
    /**
     * Get environmental projects list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
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

        // Apply translations if needed
        if ($language !== 'en') {
            $projects->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json($projects);
    }

    /**
     * Get single environmental project details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $project = EnvironmentalProject::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $project->title = $project->getTranslation('title', $language);
            $project->description = $project->getTranslation('description', $language);
        }

        // Add computed properties
        $project->project_type_display = $project->project_type_display;
        $project->impact_metrics_list = $project->impact_metrics_list;

        // Get related projects (same type)
        $relatedProjects = EnvironmentalProject::published()
            ->where('id', '!=', $project->id)
            ->where('project_type', $project->project_type)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'project' => $project,
            'related_projects' => $relatedProjects
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
