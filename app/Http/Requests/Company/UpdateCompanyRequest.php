<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\ApiFormRequest;

class UpdateCompanyRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    // отловить параметр get и передача в request
    public function all($keys = null) {
        $data = parent::all($keys);
        $data['id'] = $this->route('company');
        return $data;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * правила проверки
     */
    public function rules() {
        return [
            'id' => 'required|integer|exists:companies,id',
            'title' => 'required|max:255|unique:companies,title,'.$this->id,
            'description' => 'required|string',
        ];
    }

}
