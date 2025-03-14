<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuizRequest extends FormRequest
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

        $rules = [
            'question' => ['required', 'string', 'max:1000'],
            'explanation' => ['required', 'string', 'max:1000'],
        ];

        for($i = 1; $i <= 4; $i++) {
            $rules["optionId{$i}"] = ['required', 'integer', 'exists:options,id'];
            $rules["content{$i}"] = ['required', 'string', 'max:1000'];
            $rules["is_correct{$i}"] = ['required', 'integer', 'in:0,1'];
        }

        return $rules;
    }
}
