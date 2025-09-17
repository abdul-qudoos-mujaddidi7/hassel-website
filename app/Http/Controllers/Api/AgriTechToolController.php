<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgriTechTool;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AgriTechToolController extends Controller
{
    /**
     * Get agri-tech tools list with filtering and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
        $toolType = $request->get('tool_type'); // filter by tool type
        $platform = $request->get('platform'); // filter by platform

        $query = AgriTechTool::published();

        // Apply tool type filter if provided
        if ($toolType) {
            $query->byType($toolType);
        }

        // Apply platform filter if provided
        if ($platform) {
            $query->byPlatform($platform);
        }

        $tools = $query->orderBy('created_at', 'desc')->paginate(12);

        // Apply translations if needed
        if ($language !== 'en') {
            $tools->getCollection()->transform(function ($item) use ($language) {
                $item->name = $item->getTranslation('name', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json($tools);
    }

    /**
     * Get single agri-tech tool details
     */
    public function show(string $slug, Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');

        $tool = AgriTechTool::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Apply translations if needed
        if ($language !== 'en') {
            $tool->name = $tool->getTranslation('name', $language);
            $tool->description = $tool->getTranslation('description', $language);
        }

        // Add computed properties
        $tool->is_downloadable = $tool->is_downloadable;
        $tool->tool_type_display = $tool->tool_type_display;
        $tool->platform_display = $tool->platform_display;
        $tool->features_list = $tool->features_list;

        // Get related tools (same type or platform)
        $relatedTools = AgriTechTool::published()
            ->where('id', '!=', $tool->id)
            ->where(function ($query) use ($tool) {
                $query->where('tool_type', $tool->tool_type)
                    ->orWhere('platform', $tool->platform);
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'tool' => $tool,
            'related_tools' => $relatedTools
        ]);
    }

    /**
     * Get tool types for filtering
     */
    public function types(): JsonResponse
    {
        $types = AgriTechTool::published()
            ->distinct()
            ->pluck('tool_type')
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

    /**
     * Get platforms for filtering
     */
    public function platforms(): JsonResponse
    {
        $platforms = AgriTechTool::published()
            ->distinct()
            ->pluck('platform')
            ->filter()
            ->values();

        return response()->json(['platforms' => $platforms]);
    }
}
