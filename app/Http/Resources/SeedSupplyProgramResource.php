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
        // When include_translations is set or it's an admin route, always return base English values
        $isAdminRequest = $request->get('include_translations') || $request->routeIs('api.admin.*');
        $lang = $isAdminRequest ? 'en' : $request->get('lang', 'en');
        
        // Normalize language code: frontend uses 'fa', 'ps', 'en' but model expects 'farsi', 'pashto'
        $normalizeLanguage = function($langCode) {
            $langMap = [
                'fa' => 'farsi',
                'farsi' => 'farsi',
                'ps' => 'pashto',
                'pashto' => 'pashto',
                'en' => 'en',
                'english' => 'en',
            ];
            $normalized = strtolower($langCode ?? 'en');
            return $langMap[$normalized] ?? 'en';
        };
        
        $normalizedLang = $normalizeLanguage($lang);
        
        // Helper function to get translated or base value
        $getTranslatableValue = function($field) use ($normalizedLang, $isAdminRequest) {
            // For admin requests, always return base English value
            if ($isAdminRequest) {
                return $this->$field;
            }
            // For public API, use translation if available (only for farsi/pashto)
            if ($normalizedLang !== 'en' && method_exists($this->resource, 'getTranslation')) {
                return $this->getTranslation($field, $normalizedLang) ?? $this->$field;
            }
            // For English or if no translation available, return base value
            return $this->$field;
        };
        
        return [
            'id' => $this->id,
            'name' => $getTranslatableValue('name'),
            'slug' => $this->slug,
            'description' => $getTranslatableValue('description'),
            'short_description' => $getTranslatableValue('short_description'),
            'input_type' => $getTranslatableValue('input_type'),
            'input_type_display' => ucwords(str_replace('_', ' ', $this->input_type)),
            'target_crops' => $getTranslatableValue('target_crops'),
            'formatted_target_crops' => $this->formatted_target_crops,
            'quality_grade' => $this->quality_grade,
            'price_range' => $this->price_range,
            'availability' => $this->availability,
            'shelf_life' => $this->shelf_life,
            'distribution_centers' => $getTranslatableValue('distribution_centers'),
            'formatted_distribution_centers' => $this->formatted_distribution_centers,
            'usage_instructions' => $getTranslatableValue('usage_instructions'),
            'technical_specifications' => $getTranslatableValue('technical_specifications'),
            'supplier' => $getTranslatableValue('supplier'),
            'contact_info' => $getTranslatableValue('contact_info'),
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
            
            // JSON translations for admin
            'farsi_translations' => $this->when(
                $request->get('include_translations'),
                $this->farsi_translations ?? []
            ),
            'pashto_translations' => $this->when(
                $request->get('include_translations'),
                $this->pashto_translations ?? []
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
