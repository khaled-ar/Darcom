<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\GeneralUser;
use Illuminate\Http\Request;

class GeneralUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('per_page'))
            return $this->generalResponse(GeneralUser::latest()->paginate(request('per_page')));
        return $this->generalResponse(GeneralUser::latest()->paginate());
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
    public function show(GeneralUser $general_user)
    {
        return $this->generalResponse($general_user, null, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
