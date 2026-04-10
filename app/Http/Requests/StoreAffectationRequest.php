<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAffectationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => 'required',
            'service_id' => 'required',
            'entity_id' => 'nullable',
            'sector_id' => 'nullable',
            'section_id' => 'nullable',
            'affectation_date' => 'required',
            'occupation_id' => 'required',
        ];
    }
}
