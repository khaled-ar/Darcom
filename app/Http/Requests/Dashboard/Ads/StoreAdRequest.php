<?php

namespace App\Http\Requests\Dashboard\Ads;

use App\Models\Ad;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Files;


class StoreAdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return request()->user()->role == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
            'url'   => ['nullable', 'string', 'max:2000']
        ];
    }

    public function store() {
        $ad = Ad::create($this->validated());
        if($this->hasFile('image')) {
            $ad->update(['image' => Files::moveFile($this->image, 'Images/Ads')]);
        }
        return $this->generalResponse(null, '201', 201);
    }
}
