<?php

namespace App\Http\Requests\People;

use App\Http\Requests\ApiFormRequest;

class StorePeopleRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * правила проверки
     */
    public function rules() {
        return [
            'company_id' => 'required|integer|exists:companies,id',
            'name' => 'required|string',
        ];
    }

}
