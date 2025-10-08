<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainingProgramResource extends JsonResource
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
            'description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description,
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'program_type' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('program_type', $lang) ?? $this->program_type) : $this->program_type,
            'program_type_display' => ucwords(str_replace('_', ' ', $this->program_type)),
            'duration' => $this->duration,
            'location' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('location', $lang) ?? $this->location) : $this->location,
            'instructor' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('instructor', $lang) ?? $this->instructor) : $this->instructor,
            'max_participants' => $this->max_participants,
            'start_date' => $this->start_date->toDateString(),
            'end_date' => $this->end_date->toDateString(),
            'start_date_formatted' => $this->start_date->format('M d, Y'),
            'end_date_formatted' => $this->end_date->format('M d, Y'),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes
            'available_spots' => $this->available_spots, // From model accessor
            'is_full' => $this->is_full, // From model accessor
            'program_status' => $this->program_status, // upcoming/ongoing/completed
            'can_register' => $this->when(
                method_exists($this->resource, 'canRegister'),
                $this->canRegister()
            ),
            'days_until_start' => $this->start_date->diffInDays(now()),
            'duration_in_days' => $this->start_date->diffInDays($this->end_date) + 1,

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

            // JSON translations for admin and when explicitly requested
            'farsi_translations' => $this->when(
                $request->get('include_translations') || $request->routeIs('api.admin.*'),
                $this->farsi_translations
            ),
            'pashto_translations' => $this->when(
                $request->get('include_translations') || $request->routeIs('api.admin.*'),
                $this->pashto_translations
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
                'type' => 'training_program',
                'api_version' => '1.0',
                'generated_at' => now()->toISOString(),
            ],
        ];
    }
}
