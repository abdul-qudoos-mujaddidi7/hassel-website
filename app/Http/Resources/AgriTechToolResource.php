<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgriTechToolResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'tool_type' => $this->tool_type,
            'tool_type_display' => $this->tool_type_display,
            'platform' => $this->platform,
            'platform_display' => $this->platform_display,
            'version' => $this->version,
            'features' => $this->features_list,
            'download_link' => $this->download_link,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            // Computed attributes
            'is_downloadable' => $this->is_downloadable,

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
