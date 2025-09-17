<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'stat_type' => $this->stat_type,
            'stat_type_display' => ucwords(str_replace('_', ' ', $this->stat_type)),
            'value' => $this->value,
            'description' => $this->description,
            'year' => $this->year,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            // Computed attributes
            'formatted_value' => $this->formatted_value, // From model accessor
            'value_with_suffix' => $this->when($this->value >= 1000, function () {
                if ($this->value >= 1000000) {
                    return round($this->value / 1000000, 1) . 'M';
                } elseif ($this->value >= 1000) {
                    return round($this->value / 1000, 1) . 'K';
                }
                return $this->value;
            }),

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
