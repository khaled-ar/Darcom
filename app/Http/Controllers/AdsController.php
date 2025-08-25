<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\Ads\{
    DeleteAdRequest,
    StoreAdRequest,
};
use App\Models\Ad;
use Illuminate\Http\Request;
use App\Traits\Files;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('per_page'))
            return $this->generalResponse(Ad::latest()->paginate(request('per_page')));
        return $this->generalResponse(Ad::latest()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdRequest $request)
    {
        return $request->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(DeleteAdRequest $request, Ad $ad)
    {
        $ad->delete();
        Files::deleteFile(public_path('Images/Ads' . '/' . $ad->image));
        return $this->generalResponse(null, 'Deleted Successfully', 200);
    }
}
