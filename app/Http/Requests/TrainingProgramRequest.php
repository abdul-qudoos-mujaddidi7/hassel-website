<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TrainingProgramRequest extends FormRequest
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
        // Get the training program ID for update requests - safely extract ID
        // Laravel route model binding will provide a TrainingProgram model instance
        $programId = null;
        $programModel = $this->route('trainingProgram');
        
        if ($programModel instanceof \Illuminate\Database\Eloquent\Model) {
            $programId = $programModel->getKey();
        } elseif ($programModel !== null && is_numeric($programModel)) {
            $programId = (int) $programModel;
        }

        // Build slug rule based on whether it's an update
        $slugRule = Rule::unique('training_programs', 'slug');
        if ($programId !== null) {
            $slugRule = $slugRule->ignore($programId);
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
            'cover_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Allow empty string (for clearing image)
                    if ($value === '' || $value === null) {
                        return; // Validation passes for empty/null
                    }
                    // Allow string or file - validation will pass if it's a file
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The cover image must be a string or a valid image file.');
                        return;
                    }
                    // If it's a string, check max length
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The cover image URL may not be greater than 500 characters.');
                        return;
                    }
                    // If it's a file, validate it
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
                    // Allow empty string (for clearing image)
                    if ($value === '' || $value === null) {
                        return; // Validation passes for empty/null
                    }
                    // Allow string or file - validation will pass if it's a file
                    if (!is_string($value) && !($value instanceof \Illuminate\Http\UploadedFile)) {
                        $fail('The thumbnail image must be a string or a valid image file.');
                        return;
                    }
                    // If it's a string, check max length
                    if (is_string($value) && strlen($value) > 500) {
                        $fail('The thumbnail image URL may not be greater than 500 characters.');
                        return;
                    }
                    // If it's a file, validate it
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
            'program_type' => 'required|string|max:100',
            'duration' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'instructor' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:draft,published,ongoing,completed,cancelled',
        ];

        // For update requests, make fields sometimes required
        if ($this->isMethod('PUT') || $this->isMethod('PATCH') || $this->isMethod('POST')) {
            // Slug rule is already set above with ignore, so we don't need to change it
            $rules['title'] = 'sometimes|required|string|max:255';
            $rules['description'] = 'sometimes|required|string';
            $rules['location'] = 'sometimes|required|string|max:255';
            $rules['start_date'] = 'sometimes|required|date';
            $rules['end_date'] = 'sometimes|required|date|after:start_date';
            $rules['status'] = 'sometimes|required|in:draft,published,ongoing,completed,cancelled';
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
            'program_type.required' => 'The program type is required.',
            'location.required' => 'The location is required.',
            'max_participants.integer' => 'The max participants must be a whole number.',
            'max_participants.min' => 'The max participants must be at least 1.',
            'start_date.required' => 'The start date is required.',
            'start_date.after_or_equal' => 'The start date must be today or later.',
            'end_date.required' => 'The end date is required.',
            'end_date.after' => 'The end date must be after the start date.',
            'status.required' => 'The status is required.',
            'status.in' => 'The selected status is invalid.',
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
            'cover_image' => 'cover image',
            'thumbnail_image' => 'thumbnail image',
            'program_type' => 'program type',
            'duration' => 'duration',
            'location' => 'location',
            'instructor' => 'instructor',
            'max_participants' => 'max participants',
            'start_date' => 'start date',
            'end_date' => 'end date',
            'status' => 'status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Auto-generate slug from title if not provided
        if ($this->has('title') && !$this->has('slug')) {
            $this->merge([
                'slug' => Str::slug($this->title)
            ]);
        }
    }
}