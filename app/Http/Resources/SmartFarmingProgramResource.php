<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmartFarmingProgramResource extends JsonResource
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
            'name' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('name', $lang) ?? $this->name) : $this->name,
            'slug' => $this->slug,
            'description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description,
            'short_description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('short_description', $lang) ?? $this->short_description) : $this->short_description,
            'farming_type' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('farming_type', $lang) ?? $this->farming_type) : $this->farming_type,
            'farming_type_display' => ucwords(str_replace('_', ' ', $this->farming_type)),
            'target_crops' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('target_crops', $lang) ?? $this->target_crops) : $this->target_crops,
            'formatted_target_crops' => $this->formatted_target_crops,
            'sustainability_level' => $this->sustainability_level,
            'sustainability_level_display' => $this->sustainability_level_display,
            'implementation_guide' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('implementation_guide', $lang) ?? $this->implementation_guide) : $this->implementation_guide,
            'sustainability_impact' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('sustainability_impact', $lang) ?? $this->sustainability_impact) : $this->sustainability_impact,
            'duration' => $this->duration,
            'location' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('location', $lang) ?? $this->location) : $this->location,
            'application_deadline' => $this->application_deadline?->toDateString(),
            'application_deadline_formatted' => $this->application_deadline?->format('M d, Y'),
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes
            'is_available' => $this->is_available,
            'can_apply' => $this->canApply(),
            'is_past_deadline' => $this->application_deadline && $this->application_deadline < now(),

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

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'meta' => [
                'type' => 'smart_farming_program',
                'api_version' => '1.0',
                'generated_at' => now()->toISOString(),
            ],
        ];
    }
}
