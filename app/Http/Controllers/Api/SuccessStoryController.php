<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuccessStory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\SuccessStoryResource;

class SuccessStoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->get('search');

        $query = SuccessStory::published()->orderBy('published_at', 'desc');
        $perPage = (int) ($request->get('per_page', 9));

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client_name', 'like', "%{$search}%")
                    ->orWhere('story', 'like', "%{$search}%");
            });
        }

        $stories = $query->paginate($perPage);

        return response()->json([
            'data' => SuccessStoryResource::collection($stories),
            'meta' => [
                'current_page' => $stories->currentPage(),
                'last_page' => $stories->lastPage(),
                'per_page' => $stories->perPage(),
                'total' => $stories->total(),
            ]
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $story = SuccessStory::published()->where('slug', $slug)->firstOrFail();

        $related = SuccessStory::published()
            ->where('id', '!=', $story->id)
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        return response()->json([
            'story' => new SuccessStoryResource($story),
            'related_stories' => SuccessStoryResource::collection($related),
        ]);
    }
}
