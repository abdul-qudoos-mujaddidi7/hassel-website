<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'cover_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value === '' || $value === null) {
                        return;
                    }
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The cover image must be a string or a valid image file.');
                        return;
                    }
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The cover image URL may not be greater than 500 characters.');
                        return;
                    }
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                            $fail('The cover image must be a file of type: jpeg, jpg, png, gif, webp.');
                            return;
                        }
                        if ($value->getSize() > 3072 * 1024) {
                            $fail('The cover image may not be greater than 3MB.');
                            return;
                        }
                    }
                }
            ],
            'thumbnail_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value === '' || $value === null) {
                        return;
                    }
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The thumbnail image must be a string or a valid image file.');
                        return;
                    }
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The thumbnail image URL may not be greater than 500 characters.');
                        return;
                    }
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                            $fail('The thumbnail image must be a file of type: jpeg, jpg, png, gif, webp.');
                            return;
                        }
                        if ($value->getSize() > 3072 * 1024) {
                            $fail('The thumbnail image may not be greater than 3MB.');
                            return;
                        }
                    }
                }
            ],
            'status' => 'required|string|in:draft,published,ongoing,completed,cancelled',
        ];

        // Get the program ID for update requests
        $programId = null;
        $programModel = $this->route('seedSupplyProgram');
        
        if ($programModel instanceof \Illuminate\Database\Eloquent\Model) {
            $programId = $programModel->getKey();
        } elseif ($programModel !== null && is_numeric($programModel)) {
            $programId = (int) $programModel;
        }

        // Build slug rule based on whether it's an update
        $slugRule = Rule::unique('seed_supply_programs', 'slug');
        if ($programId !== null) {
            $slugRule = $slugRule->ignore($programId);
        }

        // For updates, make name and slug unique except for current record
        if ($this->isMethod('PUT') || $this->isMethod('PATCH') || $this->isMethod('POST')) {
            $rules['name'] = 'sometimes|required|string|max:255|unique:seed_supply_programs,name,' . ($programId ?? 'NULL');
            $rules['slug'] = [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                $slugRule
            ];
        } else {
            $rules['name'] .= '|unique:seed_supply_programs,name';
            $rules['slug'] = [
                'nullable',
                'string',
                'max:255',
                $slugRule
            ];
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
