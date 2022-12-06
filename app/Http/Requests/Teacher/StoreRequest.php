<?php

namespace App\Http\Requests\Teacher;


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
            'email' => ['required', 'unique:teachers,email'],
            'password' => ['required', 'min:6', 'max:18']
        ];
    }

}
