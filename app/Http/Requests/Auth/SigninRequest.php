<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

// Авторизация
class SigninRequest extends ApiFormRequest
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
            'email' => 'required|email|min:6|max:255|exists:users,email',
            'password' => 'required|min:6|max:255|string',
        ];
    }

}
