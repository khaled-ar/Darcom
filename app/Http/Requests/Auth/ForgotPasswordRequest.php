<?php

namespace App\Http\Requests\Auth;

use App\Services\Whatsapp;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'whatsapp' => ['required', 'string', 'exists:users,whatsapp']
        ];
    }

    public function send_code() {
        if(Whatsapp::send_code($this->whatsapp))
            return $this->generalResponse(null, 'Whatsapp Check', 200);
        return $this->generalResponse(null, 'error_400', 400);
    }
}
