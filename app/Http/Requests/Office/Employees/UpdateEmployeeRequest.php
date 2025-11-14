<?php

namespace App\Http\Requests\Office\Employees;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use App\Traits\Files;

class UpdateEmployeeRequest extends FormRequest
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
            'fullname' => ['string', 'max:100'],
            'whatsapp' => ['string', 'unique:users,whatsapp'],
            'email'    => ['email',  'unique:users,email'],
            'position' => ['string', 'max:100'],
            'image' => ['image', 'mimes:png,jpg', 'max:2048'],
            'max_ads' => ['integer', 'min:1'],
        ];
    }

    public function update($employee) {
        return DB::transaction(function() use($employee) {
            $user_data = $this->only(['whatsapp', 'email']);
            $employee_data = $this->except(['whatsapp', 'email', 'image']);
            if(request()->has('image')) {
                Files::deleteFile(public_path("Images/Profiles/{$employee->image}"));
                $employee_data['image'] = Files::moveFile(request('image'), "Images/Profiles");
            }
            $employee->user()->update($user_data);
            $employee->update($employee_data);
            return $this->generalResponse(null, 'Updated Successfully', 200);
        });
    }
}
