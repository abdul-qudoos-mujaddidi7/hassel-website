<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->when($request->routeIs('admin.*'), $this->message), // Hide message in public API
            'created_at' => $this->created_at->toDateTimeString(),
            'created_date' => $this->created_at->format('M d, Y'),

            // Admin-only fields
            'admin_fields' => $this->when($request->routeIs('admin.*'), [
                'status' => $this->status ?? 'new',
                'replied_at' => $this->replied_at?->toDateTimeString(),
                'notes' => $this->notes,
                'priority' => $this->priority ?? 'normal',
            ]),
        ];
    }
}
