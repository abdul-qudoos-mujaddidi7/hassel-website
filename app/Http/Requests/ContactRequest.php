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
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'type' => 'nullable|in:general,inquiry,complaint,suggestion,partnership',
            'status' => 'nullable|in:pending,read,replied,closed',
        ];

        // For update requests, make fields sometimes required
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'] = 'sometimes|required|string|max:255';
            $rules['email'] = 'sometimes|required|email|max:255';
            $rules['subject'] = 'sometimes|required|string|max:255';
            $rules['message'] = 'sometimes|required|string|max:2000';
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
            'name.required' => 'The name is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'phone.max' => 'The phone may not be greater than 20 characters.',
            'subject.required' => 'The subject is required.',
            'subject.max' => 'The subject may not be greater than 255 characters.',
            'message.required' => 'The message is required.',
            'message.max' => 'The message may not be greater than 2000 characters.',
            'type.in' => 'The selected type is invalid.',
            'status.in' => 'The selected status is invalid.',
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
            'name' => 'name',
            'email' => 'email',
            'phone' => 'phone',
            'subject' => 'subject',
            'message' => 'message',
            'type' => 'type',
            'status' => 'status',
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

        // Set default type if not provided
        if (!$this->has('type')) {
            $this->merge([
                'type' => 'general'
            ]);
        }
    }
}