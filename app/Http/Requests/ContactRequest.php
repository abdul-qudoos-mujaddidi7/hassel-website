<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Public contact form - anyone can submit
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
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
            'name.required' => 'Please provide your name.',
            'name.max' => 'Your name cannot exceed 255 characters.',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Your email address cannot exceed 255 characters.',
            'phone.regex' => 'Please provide a valid phone number.',
            'phone.max' => 'Your phone number cannot exceed 20 characters.',
            'subject.required' => 'Please provide a subject for your message.',
            'subject.max' => 'The subject cannot exceed 255 characters.',
            'message.required' => 'Please provide your message.',
            'message.max' => 'Your message cannot exceed 2000 characters.',
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
            'name' => 'full name',
            'email' => 'email address',
            'phone' => 'phone number',
            'subject' => 'subject',
            'message' => 'message',
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

        // Trim whitespace from all text fields
        $this->merge([
            'name' => trim($this->name ?? ''),
            'email' => trim(strtolower($this->email ?? '')),
            'subject' => trim($this->subject ?? ''),
            'message' => trim($this->message ?? ''),
        ]);
    }
}
