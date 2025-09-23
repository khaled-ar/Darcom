<?php

namespace App\Http\Requests\Office\Verification;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class SendVerificationToAdminRequest extends FormRequest
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
            'id_image' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
            'license_image' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
            'commercial_register_image' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
        ];
    }

    public function store() {
        return DB::transaction(function() {
            $office = $this->user()->office;
            $office->verifications()->create($this->validated());
            return $this->generalResponse(null, '201', 201);
        });
    }
}
