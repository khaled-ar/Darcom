<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\AuthenticationException;

class RefreshTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'refresh_token' => ['required', 'string']
        ];
    }

    public function refresh() {
        $token = PersonalAccessToken::findToken($this->refresh_token);
        if (!$token || $token->expires_at->isPast())
            throw new AuthenticationException('Unauthenticated.');
        $tokens = [
            'access_token' => $token->tokenable->createToken('auth_token')->plainTextToken,
            'refresh_token' => $this->refresh_token,
        ];
        return $this->generalResponse($tokens, null, 200);
    }
}
