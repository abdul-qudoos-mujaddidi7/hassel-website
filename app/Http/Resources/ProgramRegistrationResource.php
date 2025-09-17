<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramRegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'program_type' => $this->program_type,
            'program_id' => $this->program_id,
            'user_name' => $this->user_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'location' => $this->location,
            'status' => $this->status,
            'status_display' => ucwords($this->status),
            'registration_date' => $this->registration_date->toDateString(),
            'registration_date_formatted' => $this->registration_date->format('M d, Y'),
            'created_at' => $this->created_at->toDateTimeString(),

            // Program details (when loaded)
            'program' => $this->when($this->relationLoaded('program'), function () {
                switch ($this->program_type) {
                    case 'training_program':
                        return new TrainingProgramResource($this->program);
                    case 'market_access_program':
                        return new MarketAccessProgramResource($this->program);
                    case 'community_program':
                        return new CommunityProgramResource($this->program);
                    default:
                        return null;
                }
            }),

            // Admin-only fields
            'admin_fields' => $this->when($request->routeIs('admin.*'), [
                'notes' => $this->notes,
                'approved_by' => $this->approved_by,
                'approved_at' => $this->approved_at?->toDateTimeString(),
                'updated_at' => $this->updated_at->toDateTimeString(),
            ]),
        ];
    }
}
