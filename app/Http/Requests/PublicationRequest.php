<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublicationRequest extends FormRequest
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
        $publicationId = $this->route('publication')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('publications', 'slug')->ignore($publicationId)
            ],
            'description' => 'required|string|max:1000',
            'file_path' => $isUpdate
                ? 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240'
                : 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:10240',
            'file_type' => 'required|in:report,manual,guideline,policy,research,other',
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
            'title.required' => 'The publication title is required.',
            'title.max' => 'The publication title cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'description.required' => 'A description is required for the publication.',
            'description.max' => 'The description cannot exceed 1000 characters.',
            'file_path.required' => 'A file is required for new publications.',
            'file_path.file' => 'The uploaded file must be a valid file.',
            'file_path.mimes' => 'The file must be a PDF, DOC, DOCX, XLS, XLSX, PPT, or PPTX file.',
            'file_path.max' => 'The file cannot be larger than 10MB.',
            'file_type.required' => 'Please select a file type for the publication.',
            'file_type.in' => 'The file type must be report, manual, guideline, policy, research, or other.',
            'status.required' => 'Please select a status for the publication.',
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
            'file_path' => 'publication file',
            'file_type' => 'file type',
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

        // Auto-generate slug if not provided
        if (!$this->slug && $this->title) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->title),
            ]);
        }
    }
}
