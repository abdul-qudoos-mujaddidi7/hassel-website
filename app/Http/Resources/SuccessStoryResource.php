<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        return [
            'id' => $this->id,
            'title' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'client_name' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('client_name', $lang) ?? $this->client_name) : $this->client_name,
            'story' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('story', $lang) ?? $this->story) : $this->story,
            'story_excerpt' => $this->story_excerpt,
            'image' => $this->image,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at?->toDateTimeString(),
            'published_date' => $this->published_at?->format('M d, Y'),

            // Computed attributes
            'is_published' => $this->is_published,
        ];
    }
}
