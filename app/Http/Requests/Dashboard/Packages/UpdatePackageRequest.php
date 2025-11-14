<?php

namespace App\Http\Requests\Dashboard\Packages;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackageRequest extends FormRequest
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
            'name' => ['string'],
            'for' => ['string', 'in:office,user'],
            'validity' => ['integer'],
            'posts_number' => ['integer'],
            'price' => ['numeric'],
            'images_number' => ['integer'],
            'videos_number' => ['integer'],
            'posts_notifications_number' => ['integer'],
            'featured_posts_number' => ['integer'],
            'support' => ['string'],
            'posts_requests_number' => ['integer'],
        ];
    }

    public function update($package) {
        $package->update($this->validated());
        return $this->generalResponse(null, 'Updated Successfully', 200);
    }
}
