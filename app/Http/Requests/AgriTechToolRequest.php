<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgriTechToolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $toolId = $this->route('agriTechTool')?->id ?? $this->route('agri_tech_tool')?->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('agri_tech_tools', 'slug')->ignore($toolId)
            ],
            'description' => 'required|string',
            'short_description' => 'nullable|string',
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
            'tool_type' => 'required|in:mobile_app,web_platform,hardware,software,sensor',
            'platform' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:50',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'specifications' => 'nullable|string',
            'usage_instructions' => 'nullable|string',
            'maintenance_requirements' => 'nullable|string',
            'technology_level' => 'nullable|string',
            'availability' => 'nullable|string',
            'price_range' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'contact_info' => 'nullable|string|max:500',
            'download_link' => 'nullable|url|max:500',
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The tool name is required.',
            'description.required' => 'A tool description is required.',
            'tool_type.required' => 'Please select a tool type.',
            'tool_type.in' => 'Invalid tool type selected.',
            'download_link.url' => 'The download link must be a valid URL.',
            'features.array' => 'Features must be an array.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->name) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->name)]);
        }

        // Arrays will be automatically converted to JSON by the model's casts
        // Don't convert here as validation needs to see arrays
    }
}
