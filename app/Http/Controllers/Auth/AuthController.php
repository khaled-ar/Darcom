<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\{
    ForgotPasswordRequest,
    LoginRequest,
    RefreshTokenRequest,
    RegisterGeneralUserRequest,
    RegisterOfficeRequest,
    ResetPasswordRequest,
    Verify2FARequest,
    VerifyAccountRequest,
    VerifyCodeRequest,
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

    public function forgot_password(ForgotPasswordRequest $request) {
        return $request->send_code();
    }

    public function reset_password(ResetPasswordRequest $request) {
        return $request->reset_password();
    }

    public function resend_code(ForgotPasswordRequest $request) {
        return $request->send_code();
    }

    public function verify_code(VerifyCodeRequest $request) {
        return $request->verify_code();
    }
}
