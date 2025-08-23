<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateGeneralUserProfileRequest extends FormRequest
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
            'fullname' => ['string', 'max:100'],
            'city'     => ['string', 'exists:cities,city'],
            'whatsapp' => ['string', 'unique:users,whatsapp'],
            'email'    => ['email',  'unique:users,email'],
            'image'    => ['image', 'mimes:png,jpg', 'max:2048'],
        ];
    }

    public function update() {
        return DB::transaction(function() {
            $user = $this->user();
            $user->update($this->only(['email', 'whatsapp']));
            $general_user = $user->general_user;
            $general_user->update($this->except(['email', 'whatsapp', 'image']));
            return $this->generalResponse($user->load('general_user'), 'Updated Successfully', 200);
        });
    }
}
