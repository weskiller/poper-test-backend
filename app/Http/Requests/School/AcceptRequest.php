<?php

namespace App\Http\Requests\School;


use App\Concrete\FormRequest;

class AcceptRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'code' => ['required'],
        ];
    }
}
