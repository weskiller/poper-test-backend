<?php

namespace App\Http\Requests\Teacher;


use App\Concrete\FormRequest;

class SendRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'school_id' => ['required', 'exists:schools,id'],
            'email' => ['required'],
        ];
    }

}
