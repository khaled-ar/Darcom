<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Employees\{
    AddEmployeeRequest,
};
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Traits\Files;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(request()->user()->office->employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddEmployeeRequest $request)
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
    public function destroy(Employee $employee)
    {
        Files::deleteFile(public_path("Images/Profiles/{$employee->image}"));
        $employee->user()->delete();
        $employee->delete();
        return $this->generalResponse(null, 'Deleted Successfully', 200);
    }
}
