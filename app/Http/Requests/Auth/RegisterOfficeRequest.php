<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Services\Whatsapp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class RegisterOfficeRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', 'unique:offices,name'],
            'registration_number' => ['required', 'string', 'unique:offices,registration_number'],
            'admin_name' => ['required', 'string', 'max:100', 'unique:offices,admin_name'],
            'phone_number' => ['required', 'string', 'unique:offices,phone_number'],
            'landline_number' => ['string', 'unique:offices,landline_number'],
            'full_address' => ['required', 'string', 'max:100'],
            'location_lon' => ['required', 'string', 'max:50'],
            'location_lat' => ['required', 'string', 'max:50'],
            'work_cities' => ['required', 'string', 'max:100'],
            'employees_number' => ['required', 'integer', 'min:1'],
            'logo' => ['file', 'mimes:png,jpg', 'max:2048'],
            'work_times' => ['array', 'max:7'],
            'whatsapp_link' => ['string'],
            'facebook_link' => ['string'],
            'twitter_link' => ['string'],
            'instagram_link' => ['string'],
            'telegram_link' => ['string'],
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
                $user->forceFill(['role' => 'office']);
                $user->save();
                $user->office()->create($this->except(['whatsapp', 'email', 'password', 'password_confirmation', 'work_times', 'whatsapp_link', 'facebook_link', 'twitter_link', 'instagram_link', 'telegram_link']));
                return $this->generalResponse(null, 'Whatsapp Check', 201);
            }
            return $this->generalResponse(null, 'error_400', 400);
        });
    }
}
