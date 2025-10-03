<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeedSupplyProgramRequest extends FormRequest
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
            'input_type' => 'nullable|string|in:seeds,fertilizers,pesticides,tools,equipment,distribution',
            'target_crops' => 'nullable|array',
            'target_crops.*' => 'string|in:cereals,vegetables,fruits,pulses,oilseeds,spices,cash_crops',
            'quality_grade' => 'nullable|string|max:50',
            'price_range' => 'nullable|string|max:100',
            'availability' => 'nullable|string|in:In Stock,Limited,Out of Stock,Coming Soon',
            'shelf_life' => 'nullable|string|max:100',
            'distribution_centers' => 'nullable|array',
            'distribution_centers.*' => 'string|max:255',
            'usage_instructions' => 'nullable|string',
            'technical_specifications' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:500',
            'thumbnail_image' => 'nullable|string|max:500',
            'status' => 'required|string|in:draft,published,ongoing,completed,cancelled',
        ];

        // For updates, make name and slug unique except for current record
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] .= '|unique:seed_supply_programs,name,' . $this->route('seedSupplyProgram');
            $rules['slug'] = 'nullable|string|max:255|unique:seed_supply_programs,slug,' . $this->route('seedSupplyProgram');
        } else {
            $rules['name'] .= '|unique:seed_supply_programs,name';
            $rules['slug'] = 'nullable|string|max:255|unique:seed_supply_programs,slug';
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
            'input_type.in' => 'The input type must be one of: seeds, fertilizers, pesticides, tools, equipment, distribution.',
            'target_crops.array' => 'Target crops must be an array.',
            'target_crops.*.in' => 'Each target crop must be one of: cereals, vegetables, fruits, pulses, oilseeds, spices, cash crops.',
            'availability.in' => 'Availability must be one of: In Stock, Limited, Out of Stock, Coming Soon.',
            'distribution_centers.array' => 'Distribution centers must be an array.',
            'distribution_centers.*.string' => 'Each distribution center must be a string.',
            'status.required' => 'The program status is required.',
            'status.in' => 'Status must be one of: draft, published, ongoing, completed, cancelled.',
        ];
    }
}
