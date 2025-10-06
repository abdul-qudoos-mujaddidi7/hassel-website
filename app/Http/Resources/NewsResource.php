<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        return [
            'id' => $this->id,
            'title' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'excerpt' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('excerpt', $lang) ?? $this->excerpt) : $this->excerpt,
            'content' => $this->when($request->routeIs('api.news.show'), method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('content', $lang) ?? $this->content) : $this->content),
            'featured_image' => $this->featured_image,
            'featured_image_url' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'status' => $this->status,
            'published_at' => $this->published_at?->toDateTimeString(),
            'published_date' => $this->published_at?->format('M d, Y'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes from model
            'is_published' => $this->is_published,
            'excerpt_limited' => $this->excerpt_limited,

            // Conditional fields
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),

            // Admin-only fields
            'admin_fields' => $this->when($request->routeIs('admin.*'), [
                'view_count' => $this->view_count ?? 0,
                'last_modified_by' => $this->last_modified_by ?? null,
            ]),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'type' => 'news',
                'api_version' => '1.0',
                'generated_at' => now()->toISOString(),
            ],
        ];
    }
}
