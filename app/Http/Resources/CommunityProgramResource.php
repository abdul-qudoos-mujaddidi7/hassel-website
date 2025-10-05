<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');
        return [
            'id' => $this->id,
            'title' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description,
            'featured_image' => $this->featured_image ? asset($this->featured_image) : null,
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'program_type' => $this->program_type,
            'program_type_display' => $this->program_type_display,
            'target_group' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('target_group', $lang) ?? $this->target_group) : $this->target_group,
            'target_group_display' => $this->target_group_display,
            'partner_organizations' => $this->partner_organizations_list,
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
