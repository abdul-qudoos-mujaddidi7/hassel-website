<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PublicationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:publications,slug',
            'description' => 'required|string',
            'file_path' => 'nullable|string|max:500',
            'file_type' => 'nullable|string|max:50',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];

        // For update requests, make fields sometimes required
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['slug'] = 'nullable|string|max:255|unique:publications,slug,' . $this->route('publication');
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['description'] = 'sometimes|required|string';
            $rules['status'] = 'sometimes|required|in:draft,published,archived';
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
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'slug.unique' => 'The slug has already been taken.',
            'description.required' => 'The description is required.',
            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid.',
            'published_at.date' => 'The published date must be a valid date.',
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
            'title' => 'title',
            'slug' => 'slug',
            'description' => 'description',
            'file_path' => 'file path',
            'file_type' => 'file type',
            'status' => 'status',
            'published_at' => 'published date',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Set published_at to current time if status is published and published_at is not set
        if ($this->status === 'published' && !$this->has('published_at')) {
            $this->merge([
                'published_at' => now()
            ]);
        }

        // Auto-generate slug from title if not provided
        if ($this->has('title') && !$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }
    }
}