<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgriTechToolResource extends JsonResource
{
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
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'tool_type' => $this->tool_type,
            'tool_type_display' => $this->tool_type_display,
            'category' => $this->tool_type_display ?? ucwords(str_replace('_', ' ', $this->tool_type ?? '')),
            'platform' => $this->platform,
            'platform_display' => $this->platform_display,
            'version' => $this->version,
            'features' => $this->features_list,
            'specifications' => $getTranslatableValue('specifications'),
            'usage_instructions' => $getTranslatableValue('usage_instructions'),
            'maintenance_requirements' => $getTranslatableValue('maintenance_requirements'),
            'technology_level' => $this->technology_level,
            'availability' => $this->availability,
            'price_range' => $this->price_range,
            'supplier' => $this->supplier,
            'contact_info' => $this->contact_info,
            'download_link' => $this->download_link,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes
            'is_downloadable' => $this->is_downloadable,

            // JSON translations for admin and when explicitly requested
            'farsi_translations' => $this->when(
                $request->get('include_translations') || $request->routeIs('api.admin.*'),
                $this->farsi_translations
            ),
            'pashto_translations' => $this->when(
                $request->get('include_translations') || $request->routeIs('api.admin.*'),
                $this->pashto_translations
            ),

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
