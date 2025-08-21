<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;

class VerifyAccountRequest extends FormRequest
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
            'whatsapp' => ['required'],
            'code'     => ['required'],
        ];
    }

    public function verify_account() {
        $code = Cache::get($this->whatsapp);
        if($code == $this->code) {
            User::whereWhatsapp($this->whatsapp)->update([
                'whatsapp_verified_at' => now()
            ]);
            Cache::forget($this->whatsapp);
            return $this->generalResponse(null, 'Account Verified', 200);
        }
        return $this->generalResponse(null, 'Wrong Code', 400);
    }
}

