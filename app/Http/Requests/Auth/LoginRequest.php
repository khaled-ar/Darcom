<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Services\Whatsapp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
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
            'whatsapp' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }

    public function authenticate()
    {
        return Auth::attempt(
            [
                'whatsapp' => $this->whatsapp,
                'password' => $this->password,
            ]
        );
    }

    public function check() {
        if($this->authenticate()) {
            $user = User::whereWhatsapp($this->whatsapp)->first();
            if($user['2FA']) {
                $res = Whatsapp::send_code($this->whatsapp);
                return $res
                    ? $this->generalResponse(null, 'Whatsapp Check', 201)
                    : $this->generalResponse(null, 'error_400', 400);
            }
            $user['token'] = $user->createToken($user->whatsapp)->plainTextToken;
            return $this->generalResponse($user, null, 200);
        }
        return $this->generalResponse(null, 'Wrong Credentials', 401);
    }
}
