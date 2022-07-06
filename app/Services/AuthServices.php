<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthServices {

    /**
     * регистрация
     * @param $index
     * @return mixed
     */
    public function signup($index){

        $user = User::create([
            'email'=>$index['email'],
            'password'=>Hash::make($index['password']),
            'email_verified_at'=>now(),
        ]);

        // Создать Token пересоздать
        $user->api_token = $this->createToken($user)->accessToken;

        return $user;
    }

    /**
     * авторизация
     * @param $index
     * @return \Illuminate\Contracts\Auth\Authenticatable|string|null
     */
    public function signin($index){

        if (!Auth::attempt($index)) {
            return 'User not found';
        }
        $user = Auth::user();
        // Создать Token пересоздать
        $user->api_token = $this->createToken($user)->accessToken;

        return $user;
    }

    // PRIVATE
    /**
     * Создать Token для авторизованного
     * @param $user
     * @return mixed
     */
    protected function createToken($user) {
        // если есть Удалить Token юзера
        $this->deleteToken($user);
        $token = $user->createToken('Personal Access Token');
        $token->token->save();
        return $token;
    }

    /**
     * Удалить Token юзера
     * @param $user
     */
    protected function deleteToken($user) {
        DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
    }

}
