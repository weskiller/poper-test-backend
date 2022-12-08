<?php

namespace App\Http\Requests\OAuth;

use App\Concrete\FormRequest;
use Illuminate\Validation\Rule;

class ValidateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'identity' => ['required', Rule::in(['student', 'teacher'])],
        ];
    }
}
