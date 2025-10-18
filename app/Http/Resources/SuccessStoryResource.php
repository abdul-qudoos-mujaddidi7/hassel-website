<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessStoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        
        // Helper function to ensure UTF-8 encoding
        $ensureUtf8 = function ($value) {
            if (is_string($value)) {
                // Remove or replace invalid UTF-8 sequences
                return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }
            return $value;
        };
        
        return [
            'id' => $this->id,
            'title' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title),
            'slug' => $ensureUtf8($this->slug),
            'client_name' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('client_name', $lang) ?? $this->client_name) : $this->client_name),
            'story' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('story', $lang) ?? $this->story) : $this->story),
            'story_excerpt' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? 
                substr(strip_tags($this->getTranslation('story', $lang) ?? $this->story), 0, 200) . '...' : 
                $this->story_excerpt),
            'image' => $this->image,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at?->toDateTimeString(),
            'published_date' => $this->published_at?->format('M d, Y'),

            // Computed attributes
            'is_published' => $this->is_published,

            // Admin-only: include raw JSON translations when requested
            'farsi_translations' => $this->when($request->get('include_translations') || $request->routeIs('api.admin.*'), $this->farsi_translations),
            'pashto_translations' => $this->when($request->get('include_translations') || $request->routeIs('api.admin.*'), $this->pashto_translations),
        ];
    }
}
