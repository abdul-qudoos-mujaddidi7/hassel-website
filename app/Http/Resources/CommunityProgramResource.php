<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityProgramResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'program_type' => $this->program_type,
            'program_type_display' => $this->program_type_display,
            'target_group' => $this->target_group,
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
