<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\EnvironmentalProject;
use App\Services\TranslationSyncService;
use App\Http\Requests\EnvironmentalProjectRequest;
use App\Http\Resources\EnvironmentalProjectResource;

class EnvironmentalProjectsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = EnvironmentalProject::query()->orderBy('created_at', 'desc');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('funding_source', 'like', "%{$search}%");
            });
        }
        if ($status) {
            $query->where('status', $status);
        }
        $items = $query->paginate($perPage);
        return response()->json([
            'success' => true,
            'data' => EnvironmentalProjectResource::collection($items),
            'meta' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ],
        ]);
    }

    public function store(EnvironmentalProjectRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $item = EnvironmentalProject::create($validated);
        TranslationSyncService::sync($item, $translations);

        return response()->json(['success' => true, 'data' => new EnvironmentalProjectResource($item)], 201);
    }

    public function show(EnvironmentalProject $environmentalProject): JsonResponse
    {
        return response()->json(['success' => true, 'data' => new EnvironmentalProjectResource($environmentalProject)]);
    }

    public function update(EnvironmentalProjectRequest $request, EnvironmentalProject $environmentalProject): JsonResponse
    {
        $validated = $request->validated();

        $translations = $validated['translations'] ?? [];
        unset($validated['translations']);

        $environmentalProject->update($validated);
        TranslationSyncService::sync($environmentalProject, $translations);

        return response()->json(['success' => true, 'data' => new EnvironmentalProjectResource($environmentalProject)]);
    }

    public function destroy(EnvironmentalProject $environmentalProject): JsonResponse
    {
        $environmentalProject->delete();
        return response()->json(['success' => true]);
    }
}
