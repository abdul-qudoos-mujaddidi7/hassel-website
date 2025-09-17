<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RfpRfqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rfpId = $this->route('rfpRfq')?->id ?? $this->route('rfp_rfq')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        // For updates, allow deadline to be in the past (for historical records)
        $deadlineRule = $isUpdate ? 'required|date' : 'required|date|after:today';

        return [
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rfps_rfqs', 'slug')->ignore($rfpId)
            ],
            'description' => 'required|string',
            'deadline' => $deadlineRule,
            'status' => 'required|in:draft,published,archived',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The RFP/RFQ title is required.',
            'description.required' => 'A description is required.',
            'deadline.required' => 'The deadline is required.',
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
