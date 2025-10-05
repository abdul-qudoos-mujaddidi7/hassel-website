<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramRegistrationRequest extends FormRequest
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
            'program_id' => 'required|integer|exists:training_programs,id',
            'program_type' => 'required|in:training_program,smart_farming_program,seed_supply_program,market_access_program,environmental_project,community_program',
            'participant_name' => 'required|string|max:255',
            'participant_email' => 'required|email|max:255',
            'participant_phone' => 'required|string|max:20',
            'participant_address' => 'nullable|string|max:500',
            'organization' => 'nullable|string|max:255',
            'experience_level' => 'nullable|in:beginner,intermediate,advanced',
            'motivation' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string|max:1000',
        ];

        // For update requests, make fields sometimes required
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['program_id'] = 'sometimes|required|integer|exists:training_programs,id';
            $rules['program_type'] = 'sometimes|required|in:training_program,smart_farming_program,seed_supply_program,market_access_program,environmental_project,community_program';
            $rules['participant_name'] = 'sometimes|required|string|max:255';
            $rules['participant_email'] = 'sometimes|required|email|max:255';
            $rules['participant_phone'] = 'sometimes|required|string|max:20';
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
            'program_id.required' => 'The program is required.',
            'program_id.exists' => 'The selected program does not exist.',
            'program_type.required' => 'The program type is required.',
            'program_type.in' => 'The selected program type is invalid.',
            'participant_name.required' => 'The participant name is required.',
            'participant_name.max' => 'The participant name may not be greater than 255 characters.',
            'participant_email.required' => 'The participant email is required.',
            'participant_email.email' => 'The participant email must be a valid email address.',
            'participant_email.max' => 'The participant email may not be greater than 255 characters.',
            'participant_phone.required' => 'The participant phone is required.',
            'participant_phone.max' => 'The participant phone may not be greater than 20 characters.',
            'participant_address.max' => 'The participant address may not be greater than 500 characters.',
            'organization.max' => 'The organization may not be greater than 255 characters.',
            'experience_level.in' => 'The selected experience level is invalid.',
            'motivation.max' => 'The motivation may not be greater than 1000 characters.',
            'status.in' => 'The selected status is invalid.',
            'notes.max' => 'The notes may not be greater than 1000 characters.',
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
            'program_id' => 'program',
            'program_type' => 'program type',
            'participant_name' => 'participant name',
            'participant_email' => 'participant email',
            'participant_phone' => 'participant phone',
            'participant_address' => 'participant address',
            'organization' => 'organization',
            'experience_level' => 'experience level',
            'motivation' => 'motivation',
            'status' => 'status',
            'notes' => 'notes',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set default status if not provided
        if (!$this->has('status')) {
            $this->merge([
                'status' => 'pending'
            ]);
        }
    }
}