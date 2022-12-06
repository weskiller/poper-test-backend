<?php

namespace App\Concrete;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Validation\ValidationException;

class FormRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))->errorBag($this->errorBag);
    }

}
