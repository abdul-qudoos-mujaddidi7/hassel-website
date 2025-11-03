<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnvironmentalProjectResource extends JsonResource
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
            'title' => $getTranslatableValue('title'),
            'slug' => $this->slug,
            'description' => $getTranslatableValue('description'),
            'cover_image' => $this->cover_image ? asset($this->cover_image) : null,
            'thumbnail_image' => $this->thumbnail_image ? asset($this->thumbnail_image) : null,
            'project_type' => $this->project_type,
            'project_type_display' => $this->project_type_display,
            'location' => $this->location,
            'start_date' => $this->start_date ? $this->start_date->toDateString() : null,
            'end_date' => $this->end_date ? $this->end_date->toDateString() : null,
            'budget' => $this->budget,
            'impact_level' => $this->impact_level,
            'objectives' => $getTranslatableValue('objectives'),
            'methodology' => $getTranslatableValue('methodology'),
            'expected_outcomes' => $getTranslatableValue('expected_outcomes'),
            'partner_organizations' => $this->partner_organizations ?? [],
            'impact_metrics' => $this->impact_metrics_list,
            'funding_source' => $getTranslatableValue('funding_source'),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

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
}
