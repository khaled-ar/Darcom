<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class Verify2FARequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'whatsapp' => ['required'],
            'code'     => ['required'],
        ];
    }

    public function verify_2fa() {
        $code = Cache::get($this->whatsapp);
        if($code == $this->code) {
            $user = User::whereWhatsapp($this->whatsapp)->first();
            $user['token'] = $user->createToken('auth_token')->plainTextToken;
            $user['refresh_token'] = $user->createToken('refresh_token', ['*'], now()->addDays(7))->plainTextToken;
            Cache::forget($this->whatsapp);
            return $this->generalResponse($user, null, 200);
        }
        return $this->generalResponse(null, 'Wrong Code', 400);
    }
}
