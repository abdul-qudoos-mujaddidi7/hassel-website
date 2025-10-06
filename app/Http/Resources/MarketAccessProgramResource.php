<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarketAccessProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        return [
            'id' => $this->id,
            'title' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description,
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'program_type' => $this->program_type,
            'program_type_display' => ucwords(str_replace('_', ' ', $this->program_type)),
            'target_crops' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('target_crops', $lang) ?? $this->target_crops) : $this->target_crops,
            'partner_organizations' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('partner_organizations', $lang) ?? $this->partner_organizations) : $this->partner_organizations,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            // Registration data
            'registration_count' => $this->whenCounted('registrations'),
            'registrations' => $this->when(
                $request->routeIs('admin.*') && $request->get('include_registrations'),
                ProgramRegistrationResource::collection($this->whenLoaded('registrations'))
            ),

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
