<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationUpdateRequest extends FormRequest
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
        return [
            'status' => 'required|string|in:pending,accepted,rejected',
        ];
    }
    public function messages(): array
    {
        return [
            'status.required' => 'The job application status is required.',
            'status.in' => 'The job application status must be either pending, accepted, or rejected.',
        ];
    }
}
