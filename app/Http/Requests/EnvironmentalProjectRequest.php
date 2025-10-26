<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnvironmentalProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $projectId = $this->route('environmentalProject')?->id ?? $this->route('environmental_project')?->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('environmental_projects', 'slug')->ignore($projectId)
            ],
            'description' => 'required|string',
            'cover_image' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|string|max:255',
            'project_type' => 'required|in:conservation,reforestation,water_management,soil_conservation,biodiversity,climate_adaptation',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'impact_level' => 'nullable|string|in:low,medium,high,critical',
            'objectives' => 'nullable|string',
            'methodology' => 'nullable|string',
            'expected_outcomes' => 'nullable|string',
            'partner_organizations' => 'nullable|array',
            'partner_organizations.*' => 'string',
            'impact_metrics' => 'nullable|json',
            'funding_source' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,ongoing,completed,cancelled',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'description.required' => 'A project description is required.',
            'project_type.required' => 'Please select a project type.',
            'project_type.in' => 'Invalid project type selected.',
            'end_date.after' => 'End date must be after start date.',
            'budget.numeric' => 'Budget must be a valid number.',
            'budget.min' => 'Budget must be at least 0.',
            'impact_level.in' => 'Invalid impact level selected.',
            'partner_organizations.array' => 'Partner organizations must be an array.',
            'impact_metrics.json' => 'Impact metrics must be in valid JSON format.',
            'funding_source.max' => 'Funding source cannot exceed 255 characters.',
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

        // Convert impact_metrics array to JSON if needed
        if ($this->impact_metrics && is_array($this->impact_metrics)) {
            $this->merge(['impact_metrics' => json_encode($this->impact_metrics)]);
        }
    }
}
