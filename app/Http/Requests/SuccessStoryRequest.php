<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuccessStoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $storyId = $this->route('successStory')?->id ?? $this->route('success_story')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('success_stories', 'slug')->ignore($storyId)
            ],
            'client_name' => 'required|string|max:255',
            'story' => 'required|string',
            'image' => $isUpdate
                ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The success story title is required.',
            'client_name.required' => 'The client name is required.',
            'story.required' => 'The success story content is required.',
            'image.required' => 'An image is required for new success stories.',
            'image.image' => 'The file must be a valid image.',
            'image.mimes' => 'The image must be JPEG, PNG, JPG, GIF, or WebP.',
            'image.max' => 'The image cannot be larger than 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }

        if ($this->status === 'published' && !$this->published_at) {
            $this->merge(['published_at' => now()->toDateTimeString()]);
        }
    }
}
