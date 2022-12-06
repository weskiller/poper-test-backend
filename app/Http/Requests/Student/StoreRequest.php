<?php

namespace App\Http\Requests\Student;


use App\Concrete\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'school_id' => ['required'],
            'email' => ['required'],
            'password' => ['required', 'min:6', 'max:12']
        ];
    }
}
