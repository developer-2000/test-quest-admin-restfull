<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiFormRequest;

// Регистрация
use Illuminate\Support\Carbon;

class SignupRequest extends ApiFormRequest
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
            'email' => 'required|string|email|min:6|max:255|unique:users,email',
            'password' => 'required|min:6|string|max:255',
            'password_confirmation' => 'required|same:password'
        ];
    }

}
