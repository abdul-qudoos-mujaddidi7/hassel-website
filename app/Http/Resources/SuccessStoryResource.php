<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'author' => $this->client_name,
            'location' => $this->location ?? $this->region ?? '',
            'excerpt' => $this->excerpt ?? substr($this->story, 0, 160),
            'summary' => $this->summary ?? substr($this->story, 0, 200),
            'description' => $this->story,
            'story' => $this->story,
            'image' => $this->image,
            'thumbnail_image' => $this->image,
            'cover_image' => $this->image,
            'featured_image' => $this->image,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at?->toDateTimeString(),
            'published_date' => $this->published_at?->format('M d, Y'),
            'created_at' => $this->created_at->toDateTimeString(),

            // Computed attributes
            'is_published' => $this->is_published,
            'story_excerpt' => $this->when($request->routeIs('*.index'), substr($this->story, 0, 200) . '...'),

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
