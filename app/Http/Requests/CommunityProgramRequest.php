<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommunityProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $programId = $this->route('communityProgram')?->id ?? $this->route('community_program')?->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('community_programs', 'slug')->ignore($programId)
            ],
            'description' => 'required|string',
            'program_type' => 'required|in:capacity_building,financial_literacy,leadership,entrepreneurship,cooperative',
            'target_group' => 'required|in:women,youth,cooperatives,farmers,all',
            'partner_organizations' => 'nullable|json',
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
            'target_group.required' => 'Please select a target group.',
            'target_group.in' => 'Invalid target group selected.',
            'partner_organizations.json' => 'Partner organizations must be in valid JSON format.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }

        // Convert partner_organizations array to JSON if needed
        if ($this->partner_organizations && is_array($this->partner_organizations)) {
            $this->merge(['partner_organizations' => json_encode($this->partner_organizations)]);
        }
    }
}
