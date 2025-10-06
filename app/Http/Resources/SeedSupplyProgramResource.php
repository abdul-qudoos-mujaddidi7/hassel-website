<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeedSupplyProgramResource extends JsonResource
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
            'input_type' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('input_type', $lang) ?? $this->input_type) : $this->input_type,
            'input_type_display' => ucwords(str_replace('_', ' ', $this->input_type)),
            'target_crops' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('target_crops', $lang) ?? $this->target_crops) : $this->target_crops,
            'formatted_target_crops' => $this->formatted_target_crops,
            'quality_grade' => $this->quality_grade,
            'price_range' => $this->price_range,
            'availability' => $this->availability,
            'shelf_life' => $this->shelf_life,
            'distribution_centers' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('distribution_centers', $lang) ?? $this->distribution_centers) : $this->distribution_centers,
            'formatted_distribution_centers' => $this->formatted_distribution_centers,
            'usage_instructions' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('usage_instructions', $lang) ?? $this->usage_instructions) : $this->usage_instructions,
            'technical_specifications' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('technical_specifications', $lang) ?? $this->technical_specifications) : $this->technical_specifications,
            'supplier' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('supplier', $lang) ?? $this->supplier) : $this->supplier,
            'contact_info' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('contact_info', $lang) ?? $this->contact_info) : $this->contact_info,
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes
            'is_in_stock' => $this->is_in_stock,
            'is_available' => $this->is_available,
            'can_order' => $this->canOrder(),

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
                'type' => 'seed_supply_program',
                'api_version' => '1.0',
                'generated_at' => now()->toISOString(),
            ],
        ];
    }
}
