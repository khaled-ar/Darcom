<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{
    LoginRequest,
    RefreshTokenRequest,
    RegisterGeneralUserRequest,
    RegisterOfficeRequest,
    Verify2FARequest,
    VerifyAccountRequest,
};

class AuthController extends Controller
{
    public function register_general_user(RegisterGeneralUserRequest $request) {
        return $request->store();
    }

    public function register_office(RegisterOfficeRequest $request) {
        return $request->store();
    }

    public function login(LoginRequest $request) {
        return $request->check();
    }

    public function verify_account(VerifyAccountRequest $request) {
        return $request->verify_account();
    }

    public function verify_2fa(Verify2FARequest $request) {
        return $request->verify_2fa();
    }

    public function refresh_token(RefreshTokenRequest $request) {
        return $request->refresh();
    }

}
