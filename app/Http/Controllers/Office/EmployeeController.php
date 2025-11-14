<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Employees\{
    AddEmployeeRequest,
    UpdateEmployeeRequest,
};
use App\Models\Employee;
use App\Models\User;
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
    public function show(User $employee)
    {
        return $this->generalResponse($employee->posts()->paginate());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        return $request->update($employee);
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
