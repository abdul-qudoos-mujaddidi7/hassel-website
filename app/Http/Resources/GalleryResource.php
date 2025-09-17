<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'cover_image_url' => $this->cover_image_url, // Uses model accessor
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes
            'image_count' => $this->image_count, // Uses model accessor
            'is_published' => $this->is_published,

            // Related data
            'images' => GalleryImageResource::collection($this->whenLoaded('images')),

            // Conditional fields for detailed view
            'images_detailed' => $this->when(
                $request->routeIs('*.show'),
                GalleryImageResource::collection($this->whenLoaded('images'))
            ),

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
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
                'type' => 'gallery',
                'api_version' => '1.0',
                'generated_at' => now()->toISOString(),
            ],
        ];
    }
}
