<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        return [
            'id' => $this->id,
            'title' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description,
            'requirements' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('requirements', $lang) ?? $this->requirements) : $this->requirements,
            'location' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('location', $lang) ?? $this->location) : $this->location,
            'deadline' => $this->deadline->toDateString(),
            'deadline_formatted' => $this->deadline->format('M d, Y'),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            // Computed attributes
            'is_open' => $this->is_open,
            'is_expired' => $this->is_expired,
            'days_remaining' => $this->days_remaining,
            'requirements_list' => $this->requirements_list,

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                $this->whenLoaded('translations')
            ),
        ];
    }
}
