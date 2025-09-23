<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('per_page'))
            return $this->generalResponse(
                Office::select(['id', 'user_id', 'name', 'logo', 'full_address', 'verified'])
                    ->latest()
                    ->paginate(request('per_page'))
            );
            return $this->generalResponse(
                Office::select(['id', 'user_id', 'name', 'logo', 'full_address', 'verified'])
                    ->latest()
                    ->paginate()
            );
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
    public function show(Office $office)
    {
        return $this->generalResponse($office, null, 200);
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
