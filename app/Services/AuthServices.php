<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthServices {

    // ============================================
    // регистрация
    public function signup($index){
        $index['password'] = Hash::make($index['password']);

        $user = User::create([
            'email'=>$index['email'],
            'password'=>$index['password'],
        ]);

        // Создать Token пересоздать
        $user->api_token = $this->createToken($user)->accessToken;

        return $user;
    }

    // ============================================
    // авторизация
    public function signin($index){
        if (!Auth::attempt($index)) {
            return 'User not found';
        }
        $user = Auth::user();
        // Создать Token пересоздать
        $user->api_token = $this->createToken($user)->accessToken;

        return $user;
    }



//    PRIVATE
    // ===================================================
    // ===================================================
    // Создать Token для авторизованного
    protected function createToken($user) {
        // если есть Удалить Token юзера
        $this->deleteToken($user);
        $token = $user->createToken('Personal Access Token');
        $token->token->save();
        return $token;
    }

    // ===================================================
    // Удалить Token юзера
    protected function deleteToken($user) {
        DB::table('oauth_access_tokens')->where('user_id', $user->id)->delete();
    }
}
