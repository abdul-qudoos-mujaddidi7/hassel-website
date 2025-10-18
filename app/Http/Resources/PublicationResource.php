<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->get('lang', 'en');

        return [
            'id' => $this->id,
            'title' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('title', $lang) ?? $this->title) : $this->title,
            'slug' => $this->slug,
            'description' => method_exists($this->resource, 'getTranslation') ? ($this->getTranslation('description', $lang) ?? $this->description) : $this->description,
            'file_path' => $this->file_path,
            'file_url' => $this->file_path ? asset('storage/' . $this->file_path) : null,
            'file_type' => $this->file_type,
            'file_type_display' => ucwords(str_replace('_', ' ', $this->file_type)),
            'status' => $this->status,
            'published_at' => $this->published_at?->toDateTimeString(),
            'published_date' => $this->published_at?->format('M d, Y'),
            'created_at' => $this->created_at->toDateTimeString(),
            'is_published' => $this->is_published,
            'file_size' => $this->file_size,
            'download_count' => 0,
            'farsi_translations' => $this->when($request->get('include_translations'), $this->farsi_translations),
            'pashto_translations' => $this->when($request->get('include_translations'), $this->pashto_translations),
            'farsi_coverage' => $this->when($request->routeIs('admin.*'), $this->getTranslationCoverage('farsi')),
            'pashto_coverage' => $this->when($request->routeIs('admin.*'), $this->getTranslationCoverage('pashto')),
        ];
    }

    private function getTranslationCoverage(string $lang): int
    {
        $fields = ['title', 'description'];
        $translatedCount = 0;

        foreach ($fields as $field) {
            if (method_exists($this->resource, 'getTranslation')) {
                $value = $this->getTranslation($field, $lang === 'farsi' ? 'fa' : 'ps');
                if (!empty($value)) {
                    $translatedCount++;
                }
            }
        }

        return round(($translatedCount / count($fields)) * 100);
    }
}
