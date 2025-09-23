<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\UpdateProfileRequest;
use App\Models\WorkTime;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function get_profile() {
        $data = request()->user()->office->load(['user', 'social_links']);
        $data['2FA'] = $data->user['2FA'];
        unset($data->user);
        return $this->generalResponse($data);
    }

    public function update_profile(UpdateProfileRequest $request) {
        return $request->update();
    }

    public function get_work_times() {
        return $this->generalResponse(request()->user()->office->work_times);
    }

    public function update_work_times(Request $request, WorkTime $work_time) {
        $data = $request->validate(['day' => ['string'], 'start' => ['string'], 'end' => ['string']]);

        $office = request()->user()->office;
        $office->work_times()->whereId($work_time->id)->update($data);
        return $this->generalResponse(null, 'Updated Successfully', 200);
    }
}
