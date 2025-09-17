<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public registration - anyone can register
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'program_type' => 'required|in:training_program,market_access_program,community_program',
            'program_id' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    // Dynamic validation based on program_type
                    $programType = $this->input('program_type');
                    $table = $programType . 's'; // e.g., training_programs

                    if (!\Illuminate\Support\Facades\DB::table($table)->where('id', $value)->exists()) {
                        $fail('The selected program does not exist.');
                    }
                }
            ],
            'user_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'location' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'program_type.required' => 'Please select a program type.',
            'program_type.in' => 'The selected program type is invalid.',
            'program_id.required' => 'Please select a program to register for.',
            'program_id.integer' => 'Invalid program selection.',
            'user_name.required' => 'Please provide your full name.',
            'user_name.max' => 'Your name cannot exceed 255 characters.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Your email address cannot exceed 255 characters.',
            'phone.regex' => 'Please provide a valid phone number.',
            'phone.max' => 'Your phone number cannot exceed 20 characters.',
            'location.max' => 'Your location cannot exceed 255 characters.',
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
            'program_type' => 'program type',
            'program_id' => 'program',
            'user_name' => 'full name',
            'email' => 'email address',
            'phone' => 'phone number',
            'location' => 'location',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and format phone number
        if ($this->phone) {
            $this->merge([
                'phone' => preg_replace('/[^\+0-9]/', '', $this->phone),
            ]);
        }

        // Trim whitespace from text fields
        $this->merge([
            'user_name' => trim($this->user_name ?? ''),
            'email' => trim(strtolower($this->email ?? '')),
            'location' => trim($this->location ?? ''),
        ]);

        // Set registration date to now
        $this->merge([
            'registration_date' => now(),
            'status' => 'pending', // Default status
        ]);
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            // Check for duplicate registration
            $exists = \App\Models\ProgramRegistration::where('program_type', $this->program_type)
                ->where('program_id', $this->program_id)
                ->where('email', $this->email)
                ->exists();

            if ($exists) {
                $validator->errors()->add('email', 'You have already registered for this program.');
            }

            // Check if program is open for registration
            if ($this->program_type && $this->program_id) {
                $programModel = $this->getProgramModel();

                if ($programModel && method_exists($programModel, 'canRegister') && !$programModel->canRegister()) {
                    $validator->errors()->add('program_id', 'This program is not open for registration or is full.');
                }
            }
        });
    }

    /**
     * Get the program model based on type and ID
     */
    private function getProgramModel()
    {
        switch ($this->program_type) {
            case 'training_program':
                return \App\Models\TrainingProgram::find($this->program_id);
            case 'market_access_program':
                return \App\Models\MarketAccessProgram::find($this->program_id);
            case 'community_program':
                return \App\Models\CommunityProgram::find($this->program_id);
            default:
                return null;
        }
    }
}
