<?php

namespace App\Http\Requests\People;

use App\Http\Requests\ApiFormRequest;

class UpdatePeopleRequest extends ApiFormRequest
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
        $data['people_id'] = $this->route('client');
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
            'people_id' => 'required|integer|exists:peoples,id',
            'name' => 'required|string',
        ];
    }

}
