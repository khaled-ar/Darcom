<?php

namespace App\Http\Requests\Auth;

use App\Models\GeneralUser;
use App\Models\User;
use App\Services\Whatsapp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterGeneralUserRequest extends FormRequest
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
            'fullname' => ['required', 'string', 'max:100'],
            'city'     => ['required', 'string', 'exists:cities,city'],
            'whatsapp' => ['required', 'string', 'unique:users,whatsapp'],
            'email'    => ['required', 'email',  'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()],
        ];
    }

    public function store() {
        return DB::transaction(function() {
            $res = Whatsapp::send_code($this->whatsapp);
            if($res) {
                $user = User::create($this->validated());
                $user->general_user()->create([
                    'fullname' => $this->fullname,
                    'city'     => $this->city
                ]);
                return $this->generalResponse(null, 'Whatsapp Check', 201);
            }
            return $this->generalResponse(null, 'error_400', 400);

        });
    }
}
