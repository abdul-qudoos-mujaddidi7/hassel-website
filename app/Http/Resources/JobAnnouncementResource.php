<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobAnnouncementResource extends JsonResource
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
            'description' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description),
            'requirements' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('requirements', $lang) ?? $this->requirements) : $this->requirements),
            'location' => $ensureUtf8(method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('location', $lang) ?? $this->location) : $this->location),
            'salary_range' => $ensureUtf8($this->salary_range),
            'deadline' => $this->deadline?->toDateString(),
            'status' => $this->status,
            'opened_at' => $this->opened_at?->toDateTimeString(),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),

            // Computed attributes
            'is_open' => $this->is_open,
            'is_expired' => $this->is_expired,
            'days_remaining' => $this->days_remaining,
            'requirements_list' => $this->requirements_list,

            // Admin-only: include raw JSON translations when requested
            'farsi_translations' => $this->when($request->get('include_translations') || $request->routeIs('api.admin.*'), $this->farsi_translations),
            'pashto_translations' => $this->when($request->get('include_translations') || $request->routeIs('api.admin.*'), $this->pashto_translations),
        ];
    }
}
