<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Verification::whereStatus('pending')->with('office')->get());
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return DB::transaction(function() use ($request, $id) {
            $request->validate([
                'status' => ['required', 'string', 'in:accepted,rejected']
            ]);
            $verification = Verification::findOrFail($id);
            $verification->update(['status' => $request->status]);
            $verification->office()->update([
                'verified' => $request->status == 'accepted'
            ]);
            return $this->generalResponse(null, 'Updated Successfully', 200);
        });

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
