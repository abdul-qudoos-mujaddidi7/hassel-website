<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgriTechTool;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AgriTechToolRequest;
use App\Http\Resources\AgriTechToolResource;

class AdminAgriTechToolController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = AgriTechTool::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->tool_type) {
            $query->where('tool_type', $request->tool_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('description', 'like', "%{$request->search}%");
            });
        }

        $tools = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return AgriTechToolResource::collection($tools);
    }

    public function store(AgriTechToolRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('agritech-tools', 'public');
        }

        $tool = AgriTechTool::create($data);

        return response()->json([
            'message' => 'Agri-tech tool created successfully',
            'tool' => new AgriTechToolResource($tool)
        ], 201);
    }

    public function show(AgriTechTool $agriTechTool): JsonResponse
    {
        return response()->json(['tool' => new AgriTechToolResource($agriTechTool)]);
    }

    public function update(AgriTechToolRequest $request, AgriTechTool $agriTechTool): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($agriTechTool->image) {
                Storage::disk('public')->delete($agriTechTool->image);
            }
            $data['image'] = $request->file('image')->store('agritech-tools', 'public');
        }

        $agriTechTool->update($data);

        return response()->json([
            'message' => 'Agri-tech tool updated successfully',
            'tool' => new AgriTechToolResource($agriTechTool)
        ]);
    }

    public function destroy(AgriTechTool $agriTechTool): JsonResponse
    {
        if ($agriTechTool->image) {
            Storage::disk('public')->delete($agriTechTool->image);
        }

        $agriTechTool->delete();

        return response()->json(['message' => 'Agri-tech tool deleted successfully']);
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:agri_tech_tools,id',
            'action' => 'required|in:publish,unpublish,archive,delete',
        ]);

        $tools = AgriTechTool::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $tools->update(['status' => 'published', 'published_at' => now()]);
                break;
            case 'unpublish':
                $tools->update(['status' => 'draft']);
                break;
            case 'archive':
                $tools->update(['status' => 'archived']);
                break;
            case 'delete':
                foreach ($tools->get() as $tool) {
                    $this->destroy($tool);
                }
                break;
        }

        return response()->json(['message' => ucfirst($request->action) . ' operation completed successfully']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total_tools' => AgriTechTool::count(),
            'published_tools' => AgriTechTool::published()->count(),
            'draft_tools' => AgriTechTool::draft()->count(),
        ]);
    }
}
