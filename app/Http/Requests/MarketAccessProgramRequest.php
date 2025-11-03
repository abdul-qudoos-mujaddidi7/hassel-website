<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarketAccessProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $programId = $this->route('marketAccessProgram')?->id ?? $this->route('market_access_program')?->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('market_access_programs', 'slug')->ignore($programId)
            ],
            'description' => 'required|string',
            'cover_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value === '' || $value === null) {
                        return;
                    }
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The cover image must be a string or a valid image file.');
                        return;
                    }
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The cover image URL may not be greater than 500 characters.');
                        return;
                    }
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                            $fail('The cover image must be a file of type: jpeg, jpg, png, gif, webp.');
                            return;
                        }
                        if ($value->getSize() > 3072 * 1024) {
                            $fail('The cover image may not be greater than 3MB.');
                            return;
                        }
                    }
                }
            ],
            'thumbnail_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($value === '' || $value === null) {
                        return;
                    }
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The thumbnail image must be a string or a valid image file.');
                        return;
                    }
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The thumbnail image URL may not be greater than 500 characters.');
                        return;
                    }
                    if ($value instanceof \Illuminate\Http\UploadedFile) {
                        $allowedMimes = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                        if (!in_array(strtolower($value->getClientOriginalExtension()), $allowedMimes)) {
                            $fail('The thumbnail image must be a file of type: jpeg, jpg, png, gif, webp.');
                            return;
                        }
                        if ($value->getSize() > 3072 * 1024) {
                            $fail('The thumbnail image may not be greater than 3MB.');
                            return;
                        }
                    }
                }
            ],
            'program_type' => 'required|in:market_linkage,value_chain,export,cooperative_development',
            'target_crops' => 'nullable|array',
            'target_crops.*' => 'string',
            'partner_organizations' => 'nullable|array',
            'partner_organizations.*' => 'string',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The program title is required.',
            'description.required' => 'A program description is required.',
            'program_type.required' => 'Please select a program type.',
            'program_type.in' => 'Invalid program type selected.',
            'target_crops.array' => 'Target crops must be an array.',
            'partner_organizations.array' => 'Partner organizations must be an array.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }

        // Arrays will be automatically converted to JSON by the model's casts
        // Don't convert here as validation needs to see arrays
    }
}
