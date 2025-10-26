<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarketAccessProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $programId = $this->route('marketAccessProgram')?->id ?? $this->route('market_access_program')?->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('market_access_programs', 'slug')->ignore($programId)
            ],
            'description' => 'required|string',
            'cover_image' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|string|max:255',
            'program_type' => 'required|in:market_linkage,value_chain,export,cooperative_development',
            'target_crops' => 'nullable|array',
            'target_crops.*' => 'string',
            'partner_organizations' => 'nullable|array',
            'partner_organizations.*' => 'string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The program title is required.',
            'description.required' => 'A program description is required.',
            'program_type.required' => 'Please select a program type.',
            'program_type.in' => 'Invalid program type selected.',
            'target_crops.array' => 'Target crops must be an array.',
            'partner_organizations.array' => 'Partner organizations must be an array.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }

        // Convert arrays to JSON for storage in the database
        // Arrays are now accepted in validation rules, but we need to convert them to JSON for database storage
        if ($this->target_crops && is_array($this->target_crops)) {
            $this->merge(['target_crops' => json_encode($this->target_crops)]);
        }

        if ($this->partner_organizations && is_array($this->partner_organizations)) {
            $this->merge(['partner_organizations' => json_encode($this->partner_organizations)]);
        }
    }
}
