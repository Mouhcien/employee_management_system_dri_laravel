<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ppr' => 'required',
            'cin' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'local_id' => 'required'
        ];
    }
}
