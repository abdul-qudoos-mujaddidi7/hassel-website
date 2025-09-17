<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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

        // Apply translations if needed
        if ($language !== 'en') {
            $publications->getCollection()->transform(function ($item) use ($language) {
                $item->title = $item->getTranslation('title', $language);
                $item->description = $item->getTranslation('description', $language);
                return $item;
            });
        }

        return response()->json($publications);
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
