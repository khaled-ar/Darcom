<?php

namespace App\Http\Requests\Dashboard\Cities;

use App\Models\City;
use Illuminate\Foundation\Http\FormRequest;

class StoreCityRequest extends FormRequest
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
            'city' => ['required', 'string', 'max:50', 'unique:cities,city']
        ];
    }

    public function store() {
        $city = City::create($this->validated());
        return $this->generalResponse($city->id, '201', 201);
    }
}
