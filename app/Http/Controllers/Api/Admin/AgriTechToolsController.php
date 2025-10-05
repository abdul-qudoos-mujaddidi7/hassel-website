<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AgriTechTool;
use App\Services\TranslationSyncService;
use App\Http\Requests\AgriTechToolRequest;
use App\Http\Resources\AgriTechToolResource;

class AgriTechToolsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = AgriTechTool::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => AgriTechToolResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(AgriTechToolRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = AgriTechTool::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => new AgriTechToolResource($item)], 201);
    }

    public function show(AgriTechTool $agriTechTool): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new AgriTechToolResource($agriTechTool)]);
    }

    public function update(AgriTechToolRequest $request, AgriTechTool $agriTechTool): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $agriTechTool->update($validated);
        TranslationSyncService::sync($agriTechTool, $translations);

        return response()->json(['success' => true, 'data' => new AgriTechToolResource($agriTechTool)]);
    }

    public function destroy(AgriTechTool $agriTechTool): JsonResponse
    {
        $agriTechTool->delete();
        return response()->json(['success' => true]);
    }
}
