<?php

namespace App\Http\Requests\People;

use App\Http\Requests\ApiFormRequest;

class DestroyPeopleRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function all($keys = null) {
        $data = parent::all($keys);
//        $data = parent::all();
        $data['id'] = $this->route('client');
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
            'id' => 'required|integer|exists:peoples,id',
        ];
    }

}
