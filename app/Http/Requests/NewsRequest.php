<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // TODO: Implement proper authorization when auth is added
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $newsId = $this->route('news')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('news', 'slug')->ignore($newsId)
            ],
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => $isUpdate
                ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
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
            'title.required' => 'The news title is required.',
            'title.max' => 'The news title cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'excerpt.required' => 'A brief excerpt is required for the news article.',
            'excerpt.max' => 'The excerpt cannot exceed 500 characters.',
            'content.required' => 'The news content cannot be empty.',
            'featured_image.required' => 'A featured image is required for new news articles.',
            'featured_image.image' => 'The featured image must be a valid image file.',
            'featured_image.mimes' => 'The featured image must be a JPEG, PNG, JPG, GIF, or WebP file.',
            'featured_image.max' => 'The featured image cannot be larger than 2MB.',
            'status.required' => 'Please select a status for the news article.',
            'status.in' => 'The status must be either draft, published, or archived.',
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
            'featured_image' => 'featured image',
            'published_at' => 'published date',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // If status is published and no published_at date is set, set it to now
        if ($this->status === 'published' && !$this->published_at) {
            $this->merge([
                'published_at' => now()->toDateTimeString(),
            ]);
        }

        // If no slug is provided, it will be auto-generated in the model
        if (!$this->slug && $this->title) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->title),
            ]);
        }
    }
}
