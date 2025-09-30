<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Reason::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reason = $request->validate(['reason' => ['required', 'string', 'max:200', 'unique:reasons,reason']]);
        Reason::create($reason);
        return $this->generalResponse(null, '201', 201);
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
    public function update(Request $request, Reason $reason)
    {
        $request_reason = $request->validate(['reason' => ['required', 'string', 'max:200', 'unique:reasons,reason']]);
        $reason->update($request_reason);
        return $this->generalResponse(null, 'Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reason $reason)
    {
        $reason->delete();
        return $this->generalResponse(null, 'Deleted Successfully', 200);
    }
}
