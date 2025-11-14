<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AppointementsController extends Controller
{
    public function store(Request $request) {
        $key = $request->user()->id . '_' . $request->post_id;
        $date = Cache::get($key);
        if($date) {
            return $this->generalResponse(null, 'You cannot book an appointment because you already have one. Please wait two days from the date of your current appointment.', 400);
        }
        Cache::put($key, $request->date, 60 * 60 * 24 * 2);
        return $this->generalResponse(null, null, 200);
    }
}
