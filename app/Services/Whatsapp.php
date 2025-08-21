<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Whatsapp {

    public static function send_code($number) {
        $code = substr(str_shuffle('0123456789'), 0, 6);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.whatsapp_api_key'),
            'Content-Type: application/json',
            'Accept' => 'application/json',
        ])->withoutVerifying()->post('https://api.verifyway.com/api/v1', [
                "recipient" => $number,
                "type" => "otp",
                "code" => $code,
                "lang" => app()->getLocale()
        ]);

        if ($response->successful()) {
            Cache::put($number, $code, 60 * 5);
            return true;
        }
        return false;
    }
}
