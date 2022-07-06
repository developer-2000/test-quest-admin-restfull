<?php
namespace App\Http\Controllers;

use App\Http\Requests\Auth\SigninRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AutherController extends BaseApiController {

    protected $authService;

    public function __construct() {
        parent::__construct();
        $this->authService = new AuthServices();
    }

    /**
     * регистрация
     * @param  SignupRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(SignupRequest $request) {
        $index = $request->validated();
        $user = $this->authService->signup($index);

        return response()->json($user, 201);
    }

    /**
     * авторизация user
     * @param  SigninRequest  $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function signIn(SigninRequest $request) {
        $index = $request->validated();
        $user = $this->authService->signin($index);

        if(is_string($user)){
            return $this->getErrorResponse($user, 401);
        }

        return response()->json(['api_token'=>$user->api_token], 200);
    }

    public function logout() {
        if($user = Auth::user()){
            $user->tokens->each(function($token, $key) {
                $token->delete();
            });
        }
        Auth::logout();

        return response()->json($user, 200);
    }



}
