<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'file_path' => $this->file_path,
            'file_url' => $this->file_path ? asset('storage/' . $this->file_path) : null,
            'file_type' => $this->file_type,
            'file_type_display' => ucwords(str_replace('_', ' ', $this->file_type)),
            'status' => $this->status,
            'published_at' => $this->published_at?->toDateTimeString(),
            'published_date' => $this->published_at?->format('M d, Y'),
            'created_at' => $this->created_at->toDateTimeString(),

            // Computed attributes
            'is_published' => $this->is_published,
            'file_size' => $this->file_size,
            'download_count' => $this->download_count ?? 0,

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
