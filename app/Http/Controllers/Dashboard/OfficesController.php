<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Traits\Files;

class OfficesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request('per_page'))
            return $this->generalResponse(
                Office::select(['id', 'user_id', 'name', 'logo', 'full_address'])
                    ->latest()
                    ->paginate(request('per_page'))
            );
        return $this->generalResponse(
            Office::select(['id', 'user_id', 'name', 'logo', 'full_address'])
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
    public function destroy(Office $office)
    {
        Files::deleteFile(public_path("Images/Logos/{$office->logo}"));
        $office->user()->delete();
        return $this->generalResponse(null, 'Deleted Successfully', 200);
    }

    public function get_employees() {
        return $this->generalResponse(
            Employee::select(['id', 'user_id', 'office_id', 'fullname', 'image'])
                ->whereOfficeId(request('office_id'))
                ->with('user:id,whatsapp')
                ->latest()
                ->get()
        );
    }
}
