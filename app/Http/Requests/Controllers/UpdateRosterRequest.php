<?php

namespace App\Http\Requests\Controllers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRosterRequest extends FormRequest
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
            'time' => 'string',
            'type' => 'string',
            'teachers_id' => ['nullable', 'integer'], 
            
        ];
    }
}
