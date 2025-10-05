<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'slug' => 'nullable|string|max:255|unique:news,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];

        // For update requests, make slug unique except for current record
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['slug'] = 'nullable|string|max:255|unique:news,slug,' . $this->route('news');
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['content'] = 'sometimes|required|string';
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
            'excerpt.max' => 'The excerpt may not be greater than 500 characters.',
            'content.required' => 'The content is required.',
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
            'excerpt' => 'excerpt',
            'content' => 'content',
            'featured_image' => 'featured image',
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
    }
}