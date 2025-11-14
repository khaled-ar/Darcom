<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateGeneralUserProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $user = $request->user();
        if($user->role == 'general_user')
            return $this->generalResponse($user->load('general_user'));

        if($user->role == 'employee') {
            $user->load('employee');
            return $this->generalResponse([
                'id' => $user->employee->id,
                'user_id' => $user->id,
                'office_id' => $user->employee->office_id,
                'image_url' => $user->employee->image_url,
                'fullname' => $user->employee->fullname,
                'whatsapp' => $user->whatsapp,
                'office' => $user->employee->office->name,
            ]);
        }
    }

    public function update_employee(Request $request)
    {
        if($request->user()->role != 'employee')
            return $this->generalResponse(null, null, 400);

        $password = $request->validate(['password' => [
            'required', 'string', 'confirmed', Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()
                    ]])['password'];

        $request->user()->update(['password' => Hash::make($password)]);
        return $this->generalResponse(null);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeneralUserProfileRequest $request)
    {
        return $request->update();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
