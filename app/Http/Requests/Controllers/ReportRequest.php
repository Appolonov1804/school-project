<?php

namespace App\Http\Requests\Controllers;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'student' => 'string',
            'course' => 'string',
            'topic' => 'string',
            'date' => 'date',
            'lesson_description' => 'string',
            'comments' => 'nullable',
            'teachers_id' => ['nullable', 'integer'],
        ];
    }
}
