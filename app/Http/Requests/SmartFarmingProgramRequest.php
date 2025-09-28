<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmartFarmingProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'short_description' => 'nullable|string|max:500',
            'farming_type' => 'nullable|string|in:drip_irrigation,greenhouse,precision_agriculture,organic,climate_resilient,soil_health',
            'target_crops' => 'nullable|array',
            'target_crops.*' => 'string|in:vegetables,fruits,cereals,legumes,spices,medicinal',
            'sustainability_level' => 'nullable|integer|min:1|max:100',
            'implementation_guide' => 'nullable|string',
            'sustainability_impact' => 'nullable|string',
            'duration' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'application_deadline' => 'nullable|date|after:today',
            'cover_image' => 'nullable|string|max:500',
            'thumbnail_image' => 'nullable|string|max:500',
            'status' => 'required|string|in:draft,published,ongoing,completed,cancelled',
        ];

        // For updates, make name and slug unique except for current record
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] .= '|unique:smart_farming_programs,name,' . $this->route('smartFarmingProgram');
            $rules['slug'] = 'nullable|string|max:255|unique:smart_farming_programs,slug,' . $this->route('smartFarmingProgram');
        } else {
            $rules['name'] .= '|unique:smart_farming_programs,name';
            $rules['slug'] = 'nullable|string|max:255|unique:smart_farming_programs,slug';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The program name is required.',
            'name.unique' => 'A program with this name already exists.',
            'description.required' => 'The program description is required.',
            'farming_type.in' => 'The farming type must be one of: drip irrigation, greenhouse, precision agriculture, organic, climate resilient, soil health.',
            'target_crops.array' => 'Target crops must be an array.',
            'target_crops.*.in' => 'Each target crop must be one of: vegetables, fruits, cereals, legumes, spices, medicinal.',
            'sustainability_level.integer' => 'Sustainability level must be a number.',
            'sustainability_level.min' => 'Sustainability level must be at least 1%.',
            'sustainability_level.max' => 'Sustainability level cannot exceed 100%.',
            'application_deadline.date' => 'Application deadline must be a valid date.',
            'application_deadline.after' => 'Application deadline must be in the future.',
            'status.required' => 'The program status is required.',
            'status.in' => 'Status must be one of: draft, published, ongoing, completed, cancelled.',
        ];
    }
}
