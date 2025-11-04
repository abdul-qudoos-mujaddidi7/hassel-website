<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class JobAnnouncementRequest extends FormRequest
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
        // Get the job announcement ID for update requests - safely extract ID
        // Laravel route model binding will provide a JobAnnouncement model instance
        $jobId = null;
        $jobModel = $this->route('job_announcement');
        
        if ($jobModel instanceof \Illuminate\Database\Eloquent\Model) {
            $jobId = $jobModel->getKey();
        } elseif ($jobModel !== null && is_numeric($jobModel)) {
            $jobId = (int) $jobModel;
        }

        // Build slug rule based on whether it's an update
        $slugRule = Rule::unique('job_announcements', 'slug');
        if ($jobId !== null) {
            $slugRule = $slugRule->ignore($jobId);
        }

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                $slugRule
            ],
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'location' => 'required|string|max:255',
            'salary_range' => 'nullable|string|max:100',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:draft,published,closed,open',
            'published_at' => 'nullable|date',
            'farsi_translations' => 'nullable|array',
            'pashto_translations' => 'nullable|array',
            'translations' => 'nullable|array',
        ];

        // For update requests, make fields sometimes required
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['description'] = 'sometimes|required|string';
            $rules['location'] = 'sometimes|required|string|max:255';
            $rules['deadline'] = 'sometimes|required|date|after:today';
            $rules['employment_type'] = 'sometimes|required|in:full_time,part_time,contract,internship';
            $rules['experience_level'] = 'sometimes|required|in:entry,mid,senior,executive';
            $rules['application_deadline'] = 'sometimes|required|date';
            $rules['status'] = 'sometimes|required|in:draft,published,closed,open';
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
            'location.required' => 'The location is required.',
            'employment_type.required' => 'The employment type is required.',
            'employment_type.in' => 'The selected employment type is invalid.',
            'experience_level.required' => 'The experience level is required.',
            'experience_level.in' => 'The selected experience level is invalid.',
            'application_deadline.required' => 'The application deadline is required.',
            'application_deadline.after' => 'The application deadline must be in the future.',
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
            'requirements' => 'requirements',
            'responsibilities' => 'responsibilities',
            'location' => 'location',
            'employment_type' => 'employment type',
            'experience_level' => 'experience level',
            'salary_range' => 'salary range',
            'application_deadline' => 'application deadline',
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
