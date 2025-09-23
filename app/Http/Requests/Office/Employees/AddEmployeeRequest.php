<?php

namespace App\Http\Requests\Office\Employees;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class AddEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string', 'max:100'],
            'whatsapp' => ['required', 'string', 'unique:users,whatsapp'],
            'email'    => ['required', 'email',  'unique:users,email'],
            'position' => ['required', 'string', 'max:100'],
            'image' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
            'max_ads' => ['integer', 'min:1'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)
                    ->max(25)
                    ->numbers()
                    ->symbols()
                    ->mixedCase()
                    ->uncompromised()],
        ];
    }

    public function store() {
        return DB::transaction(function() {
            $office = $this->user()->office;
            if($office->employees_number == $office->employees()->count()) {
                return $this->generalResponse(null, 'The maximum number of employees has been reached.', 400);
            }
            $user = $this->only(['whatsapp', 'email', 'password']);
            $user = User::create($user);
            $user->forceFill(['role' => 'employee']);
            $user->save();
            $employee = $this->except(['whatsapp', 'email', 'password', 'password_confirmation']);
            $employee['user_id'] = $user->id;
            $office->employees()->create($employee);
            return $this->generalResponse(null, '201', 201);
        });
    }
}
