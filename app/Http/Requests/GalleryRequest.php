<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $galleryId = $this->route('gallery')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('galleries', 'slug')->ignore($galleryId)
            ],
            'description' => 'nullable|string|max:1000',
            'cover_image' => $isUpdate
                ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                : 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'images' => 'nullable|array|max:20', // Allow up to 20 images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The gallery title is required.',
            'cover_image.required' => 'A cover image is required for new galleries.',
            'cover_image.image' => 'The cover image must be a valid image.',
            'cover_image.mimes' => 'The cover image must be JPEG, PNG, JPG, GIF, or WebP.',
            'cover_image.max' => 'The cover image cannot be larger than 2MB.',
            'images.array' => 'Images must be provided as an array.',
            'images.max' => 'You cannot upload more than 20 images at once.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Each image must be JPEG, PNG, JPG, GIF, or WebP.',
            'images.*.max' => 'Each image cannot be larger than 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }
    }
}
