<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $jobId = $this->route('jobAnnouncement')?->id ?? $this->route('job')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        // For updates, allow deadline to be in the past
        $deadlineRule = $isUpdate ? 'required|date' : 'required|date|after:today';

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('job_announcements', 'slug')->ignore($jobId)
            ],
            'description' => 'required|string',
            'requirements' => 'required|string',
            'location' => 'required|string|max:255',
            'deadline' => $deadlineRule,
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'description.required' => 'A job description is required.',
            'requirements.required' => 'Job requirements are required.',
            'location.required' => 'The job location is required.',
            'deadline.required' => 'The application deadline is required.',
            'deadline.date' => 'The deadline must be a valid date.',
            'deadline.after' => 'The deadline must be in the future.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (!$this->slug && $this->title) {
            $this->merge(['slug' => \Illuminate\Support\Str::slug($this->title)]);
        }

        if ($this->deadline && is_string($this->deadline)) {
            $this->merge(['deadline' => \Carbon\Carbon::parse($this->deadline)->format('Y-m-d')]);
        }
    }
}
