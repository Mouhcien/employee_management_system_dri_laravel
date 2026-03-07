<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAffectationRequest extends FormRequest
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
            'entity_id' => 'required',
            'sector_id' => 'required',
            'section_id' => 'required',
            'affectation_date' => 'required',
        ];
    }
}
