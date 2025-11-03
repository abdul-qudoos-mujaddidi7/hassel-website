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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the news ID for update requests - safely extract ID
        // Laravel route model binding will provide a News model instance
        $newsId = null;
        $newsModel = $this->route('news');
        
        if ($newsModel instanceof \Illuminate\Database\Eloquent\Model) {
            $newsId = $newsModel->getKey();
        } elseif ($newsModel !== null && is_numeric($newsModel)) {
            $newsId = (int) $newsModel;
        }

        // Build slug rule based on whether it's an update
        $slugRule = Rule::unique('news', 'slug');
        if ($newsId !== null) {
            $slugRule = $slugRule->ignore($newsId);
        }
        
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                $slugRule
            ],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Allow empty string (for clearing image)
                    if ($value === '' || $value === null) {
                        return; // Validation passes for empty/null
                    }
                    // Allow string or file - validation will pass if it's a file
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The featured image must be a string or a valid image file.');
                        return;
                    }
                    // If it's a string, check max length
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The featured image URL may not be greater than 500 characters.');
                        return;
                    }
                    // If it's a file, validate it
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                            $fail('The featured image must be a file of type: jpeg, jpg, png, gif, webp.');
                            return;
                        }
                        if ($value->getSize() > 3072 * 1024) {
                            $fail('The featured image may not be greater than 3MB.');
                            return;
                        }
                    }
                }
            ],
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];

        // For update requests, make fields optional
        if ($newsId) {
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
        if ($this->input('status') === 'published' && !$this->has('published_at')) {
            $this->merge([
                'published_at' => now()
            ]);
        }
    }
}