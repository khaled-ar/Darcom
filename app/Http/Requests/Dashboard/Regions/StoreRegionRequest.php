<?php

namespace App\Http\Requests\Dashboard\Regions;

use App\Models\Region;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegionRequest extends FormRequest
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
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'region' => ['required', 'string', 'max:50']
        ];
    }

    public function store() {
        Region::create($this->validated());
        return $this->generalResponse(null, '201', 201);
    }
}
