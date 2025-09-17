<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PublicationResource;

class PublicationController extends Controller
{
    /**
     * Get publications list with pagination and language support
     */
    public function index(Request $request): JsonResponse
    {
        $language = $request->get('lang', 'en');
        $type = $request->get('type'); // filter by file_type

        $query = Publication::published();

        // Apply file type filter if provided
        if ($type) {
            $query->where('file_type', $type);
        }

        $publications = $query->orderBy('published_at', 'desc')->paginate(12);

        return PublicationResource::collection($publications);
    }

    /**
     * Get publication types for filtering
     */
    public function types(): JsonResponse
    {
        $types = Publication::published()
            ->distinct()
            ->pluck('file_type')
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
