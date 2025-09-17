<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgriTechTool;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminAgriTechToolController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AgriTechTool::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('tool_type')) {
            $query->where('tool_type', $request->tool_type);
        }

        $tools = $query->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($tools);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:agri_tech_tools,slug|max:255',
            'description' => 'required|string',
            'tool_type' => 'required|in:mobile_app,web_platform,hardware,software,sensor',
            'platform' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:50',
            'features' => 'nullable|json',
            'download_link' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $tool = AgriTechTool::create($data);

        return response()->json(['message' => 'AgriTech tool created', 'tool' => $tool], 201);
    }

    public function show(AgriTechTool $agriTechTool): JsonResponse
    {
        return response()->json(['tool' => $agriTechTool]);
    }

    public function update(Request $request, AgriTechTool $agriTechTool): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:agri_tech_tools,slug,' . $agriTechTool->id,
            'description' => 'required|string',
            'tool_type' => 'required|in:mobile_app,web_platform,hardware,software,sensor',
            'platform' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:50',
            'features' => 'nullable|json',
            'download_link' => 'nullable|url',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $agriTechTool->update($data);

        return response()->json(['message' => 'AgriTech tool updated', 'tool' => $agriTechTool->fresh()]);
    }

    public function destroy(AgriTechTool $agriTechTool): JsonResponse
    {
        $agriTechTool->translations()->delete();
        $agriTechTool->delete();

        return response()->json(['message' => 'AgriTech tool deleted']);
    }
}
