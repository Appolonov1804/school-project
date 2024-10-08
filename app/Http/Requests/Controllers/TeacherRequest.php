<?php

namespace App\Http\Requests\Controllers;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'email' => 'email',
            'name' => 'string',
            'position' => 'string',
            'user_id' => ['nullable', 'integer'],
            'salary' => 'integer',
            'taxes' => 'integer'
        ];
    }
}
