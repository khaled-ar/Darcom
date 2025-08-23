<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateGeneralUserProfileRequest;
use Illuminate\Http\Request;

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
