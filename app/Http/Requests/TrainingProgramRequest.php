<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrainingProgramRequest extends FormRequest
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
        $programId = $this->route('trainingProgram')?->id ?? $this->route('training_program')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        // For updates, allow start_date to be in the past
        $startDateRule = $isUpdate ? 'required|date' : 'required|date|after:today';

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('training_programs', 'slug')->ignore($programId)
            ],
            'description' => 'required|string',
            'cover_image' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|string|max:255',
            'program_type' => 'required|in:basic,advanced,specialized,workshop,field_school',
            'duration' => 'required|string|max:100',
            'location' => 'required|string|max:255',
            'instructor' => 'required|string|max:255',
            'max_participants' => 'required|integer|min:1|max:1000',
            'start_date' => $startDateRule,
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,published,archived',
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
            'title.required' => 'The program title is required.',
            'title.max' => 'The program title cannot exceed 255 characters.',
            'slug.unique' => 'This slug is already taken. Please choose a different one.',
            'description.required' => 'A program description is required.',
            'program_type.required' => 'Please select a program type.',
            'program_type.in' => 'The program type must be basic, advanced, specialized, workshop, or field_school.',
            'duration.required' => 'The program duration is required.',
            'duration.max' => 'The duration cannot exceed 100 characters.',
            'location.required' => 'The program location is required.',
            'location.max' => 'The location cannot exceed 255 characters.',
            'instructor.required' => 'The instructor name is required.',
            'instructor.max' => 'The instructor name cannot exceed 255 characters.',
            'max_participants.required' => 'The maximum number of participants is required.',
            'max_participants.integer' => 'The maximum participants must be a number.',
            'max_participants.min' => 'There must be at least 1 participant allowed.',
            'max_participants.max' => 'The maximum participants cannot exceed 1000.',
            'start_date.required' => 'The program start date is required.',
            'start_date.date' => 'The start date must be a valid date.',
            'start_date.after' => 'The start date must be in the future.',
            'end_date.required' => 'The program end date is required.',
            'end_date.date' => 'The end date must be a valid date.',
            'end_date.after' => 'The end date must be after the start date.',
            'status.required' => 'Please select a status for the program.',
            'status.in' => 'The status must be either draft, published, or archived.',
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
            'program_type' => 'program type',
            'max_participants' => 'maximum participants',
            'start_date' => 'start date',
            'end_date' => 'end date',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Auto-generate slug if not provided
        if (!$this->slug && $this->title) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->title),
            ]);
        }

        // Format dates if they're provided as strings
        if ($this->start_date && is_string($this->start_date)) {
            $this->merge([
                'start_date' => \Carbon\Carbon::parse($this->start_date)->format('Y-m-d'),
            ]);
        }

        if ($this->end_date && is_string($this->end_date)) {
            $this->merge([
                'end_date' => \Carbon\Carbon::parse($this->end_date)->format('Y-m-d'),
            ]);
        }
    }
}
