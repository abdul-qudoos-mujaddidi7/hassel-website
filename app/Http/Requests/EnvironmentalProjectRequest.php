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
            'project_type' => 'required|in:reforestation,water_conservation,soil_health,climate_adaptation,renewable_energy',
            'impact_metrics' => 'nullable|json',
            'funding_source' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The project title is required.',
            'description.required' => 'A project description is required.',
            'project_type.required' => 'Please select a project type.',
            'project_type.in' => 'Invalid project type selected.',
            'impact_metrics.json' => 'Impact metrics must be in valid JSON format.',
            'funding_source.max' => 'Funding source cannot exceed 255 characters.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }

        // Convert impact_metrics array to JSON if needed
        if ($this->impact_metrics && is_array($this->impact_metrics)) {
            $this->merge(['impact_metrics' => json_encode($this->impact_metrics)]);
        }
    }
}
