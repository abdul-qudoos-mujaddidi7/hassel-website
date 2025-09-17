<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RfpRfqResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'deadline' => $this->deadline->toDateString(),
            'deadline_formatted' => $this->deadline->format('M d, Y'),
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),

            // Computed attributes
            'is_open' => $this->is_open,
            'is_expired' => $this->is_expired,
            'days_remaining' => $this->days_remaining,

            // Translations
            'translations' => $this->when(
                $request->get('include_translations'),
                TranslationResource::collection($this->whenLoaded('translations'))
            ),
        ];
    }
}
