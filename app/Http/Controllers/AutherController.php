<?php
namespace App\Http\Controllers;

use App\Http\Requests\Auth\SigninRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Services\AuthServices;

class AutherController extends BaseApiController {

    protected $authService;

    public function __construct() {
        parent::__construct();
        $this->authService = new AuthServices();
    }

    // ===================================================
    // ===================================================
    // ===== регистрация
    public function signUp(SignupRequest $request) {
        $index = $request->validated();
        $user = $this->authService->signup($index);

        return response()->json($user, 201);
    }

    // ===================================================
    // ===================================================
    // ===== авторизация user
    public function signIn(SigninRequest $request) {
        $index = $request->validated();
        $user = $this->authService->signin($index);
        if(is_string($user)){
            return $this->getErrorResponse($user, 401);
        }

        return response()->json($user, 200);
    }



}
