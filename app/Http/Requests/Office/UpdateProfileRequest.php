<?php

namespace App\Http\Requests\Office;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\Files;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['string', 'max:100', 'unique:offices,name'],
            'admin_name' => ['string', 'max:100', 'unique:offices,admin_name'],
            'phone_number' => ['string', 'unique:offices,phone_number'],
            'landline_number' => ['string', 'unique:offices,landline_number'],
            'full_address' => ['string', 'max:100'],
            'location_lon' => ['string', 'max:50'],
            'location_lat' => ['string', 'max:50'],
            'work_cities' => ['string', 'max:100'],
            'logo' => ['file', 'mimes:png,jpg', 'max:2048'],
            'whatsapp_link' => ['string'],
            'facebook_link' => ['string'],
            'twitter_link' => ['string'],
            'instagram_link' => ['string'],
            'telegram_link' => ['string'],
            '2FA' => ['boolean']
        ];
    }

        public function update() {
        return DB::transaction(function() {
            $office = $this->user()->office;
            $this->user()->update(['2FA' => $this->input('2FA')]);
            $office->update($this->except(['logo', 'whatsapp_link', 'facebook_link', 'twitter_link', 'instagram_link', 'telegram_link', '2FA']));
            $office->social_links()->update($this->only(['whatsapp_link', 'facebook_link', 'twitter_link', 'instagram_link', 'telegram_link']));
            if($this->file('logo')) {
                $logo = Files::moveFile($this->logo, 'Images/Logos');
                Files::deleteFile(public_path("Images/Logos/{$office->logo}"));
                $office->update(['logo' => $logo]);
            }

            return $this->generalResponse(null, 'Updated Successfully', 200);
        });
    }
}
