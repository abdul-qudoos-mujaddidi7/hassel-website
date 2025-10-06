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
        $type = $request->get('type'); // legacy support (optional)
        $search = $request->get('search');

        $query = Publication::published();

        // Apply file type filter if provided (legacy)
        if ($type) {
            $query->where('file_type', $type);
        }

        // Apply search across title, description and file_type
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('file_type', 'like', "%{$search}%");
            });
        }

        $publications = $query->orderBy('published_at', 'desc')->paginate(12);

        return response()->json([
            'data' => PublicationResource::collection($publications),
            'meta' => [
                'current_page' => $publications->currentPage(),
                'last_page' => $publications->lastPage(),
                'per_page' => $publications->perPage(),
                'total' => $publications->total(),
            ]
        ]);
    }
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
