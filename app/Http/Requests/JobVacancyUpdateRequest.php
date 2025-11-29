<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyUpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:job_vacancies,title,' . $this->route('job-vacancy'),
            'description' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|max:255',
            'jobCategoryId' => 'required|exists:job_categories,id',
            'companyId' => 'required|exists:companies,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'The job vacancy title is required.',
            'title.string' => 'The job vacancy title must be a string.',
            'title.max' => 'The job vacancy title must be less than 255 characters.',
            'title.unique' => 'The job vacancy title must be unique.',
            'description.required' => 'The job vacancy description is required.',
            'description.string' => 'The job vacancy description must be a string.',
            'description.max' => 'The job vacancy description must be less than 255 characters.',
            'location.required' => 'The job vacancy location is required.',
            'location.string' => 'The job vacancy location must be a string.',
            'location.max' => 'The job vacancy location must be less than 255 characters.',
            'salary.required' => 'The job vacancy salary is required.',
            'salary.numeric' => 'The job vacancy salary must be a number.',
            'salary.min' => 'The job vacancy salary must be greater than 0.',
            'type.string' => 'The job vacancy type must be a string.',
            'type.max' => 'The job vacancy type must be less than 255 characters.',
            'jobCategoryId.required' => 'The job category is required.',
            'jobCategoryId.exists' => 'The job category must exist.',
            'companyId.required' => 'The company is required.',
            'companyId.exists' => 'The company must exist.',
        ];
    }
}
