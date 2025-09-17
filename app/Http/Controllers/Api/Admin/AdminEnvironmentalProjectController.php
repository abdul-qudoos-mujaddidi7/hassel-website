<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalProject;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminEnvironmentalProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = EnvironmentalProject::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $projects = $query->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:environmental_projects,slug|max:255',
            'description' => 'required|string',
            'project_type' => 'required|in:reforestation,water_conservation,soil_health,climate_adaptation,renewable_energy',
            'impact_metrics' => 'nullable|json',
            'funding_source' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $project = EnvironmentalProject::create($data);

        return response()->json(['message' => 'Environmental project created', 'project' => $project], 201);
    }

    public function show(EnvironmentalProject $environmentalProject): JsonResponse
    {
        return response()->json(['project' => $environmentalProject]);
    }

    public function update(Request $request, EnvironmentalProject $environmentalProject): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:environmental_projects,slug,' . $environmentalProject->id,
            'description' => 'required|string',
            'project_type' => 'required|in:reforestation,water_conservation,soil_health,climate_adaptation,renewable_energy',
            'impact_metrics' => 'nullable|json',
            'funding_source' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $environmentalProject->update($data);

        return response()->json(['message' => 'Environmental project updated', 'project' => $environmentalProject->fresh()]);
    }

    public function destroy(EnvironmentalProject $environmentalProject): JsonResponse
    {
        $environmentalProject->translations()->delete();
        $environmentalProject->delete();

        return response()->json(['message' => 'Environmental project deleted']);
    }
}
