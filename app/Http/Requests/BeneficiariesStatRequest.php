<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BeneficiariesStatRequest extends FormRequest
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
            'stat_type' => 'required|string|in:beneficiaries,total_beneficiaries,male_beneficiaries,female_beneficiaries,programs_completed,provinces_reached,cooperatives_formed,projects,staff,partners',
            'value' => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
            'year' => 'nullable|integer|min:2000|max:2100',
        ];

        // For update requests, make fields sometimes required
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['stat_type'] = 'sometimes|required|string|in:beneficiaries,total_beneficiaries,male_beneficiaries,female_beneficiaries,programs_completed,provinces_reached,cooperatives_formed,projects,staff,partners';
            $rules['value'] = 'sometimes|required|integer|min:0';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'stat_type.required' => 'The stat type is required.',
            'stat_type.in' => 'The selected stat type is invalid.',
            'value.required' => 'The value is required.',
            'value.integer' => 'The value must be a whole number.',
            'value.min' => 'The value must be at least 0.',
            'description.max' => 'The description may not be greater than 500 characters.',
            'year.integer' => 'The year must be a valid year.',
            'year.min' => 'The year must be 2000 or later.',
            'year.max' => 'The year must be 2100 or earlier.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'stat_type' => 'stat type',
            'value' => 'value',
            'description' => 'description',
            'year' => 'year',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default year to current year if not provided
        if (!$this->has('year') || empty($this->year)) {
            $this->merge([
                'year' => now()->year
            ]);
        }
    }
}
