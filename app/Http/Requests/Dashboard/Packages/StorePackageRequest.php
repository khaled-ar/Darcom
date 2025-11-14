<?php

namespace App\Http\Requests\Dashboard\Packages;

use App\Models\Package;
use Illuminate\Foundation\Http\FormRequest;

class StorePackageRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'for' => ['required', 'string', 'in:office,user'],
            'validity' => ['required', 'integer'],
            'posts_number' => ['required', 'integer'],
            'price' => ['required', 'numeric'],
            'images_number' => ['required', 'integer'],
            'videos_number' => ['required', 'integer'],
            'posts_notifications_number' => ['integer'],
            'featured_posts_number' => ['integer'],
            'support' => ['string'],
            'posts_requests_number' => ['integer'],
        ];
    }

    public function store() {
        Package::create($this->validated());
        return $this->generalResponse(null, '201', 201);
    }
}
