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
            'cover_image' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|string|max:255',
            'tool_type' => 'required|in:mobile_app,web_platform,hardware,software,sensor',
            'platform' => 'nullable|string|max:100',
            'version' => 'nullable|string|max:50',
            'features' => 'nullable|json',
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
            'features.json' => 'Features must be in valid JSON format.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->name) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->name)]);
        }

        // Convert features array to JSON if needed
        if ($this->features && is_array($this->features)) {
            $this->merge(['features' => json_encode($this->features)]);
        }
    }
}
