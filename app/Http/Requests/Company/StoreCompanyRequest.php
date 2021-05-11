<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\ApiFormRequest;

class StoreCompanyRequest extends ApiFormRequest
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
            'title' => 'required|max:255|unique:companies,title',
            'description' => 'required|string',
        ];
    }

}
