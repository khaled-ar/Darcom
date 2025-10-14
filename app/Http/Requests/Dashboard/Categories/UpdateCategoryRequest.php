<?php

namespace App\Http\Requests\Dashboard\Categories;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Files;


class UpdateCategoryRequest extends FormRequest
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
            'name' => ['string', 'max:100', 'unique:categories,name'],
            'icon' => ['image', 'mimes:png,jpg', 'max:2048'],
        ];
    }

    public function update($category) {
        $data = $this->validated();
        if($this->file('icon')) {
            Files::deleteFile(public_path("Images/Icons/{$category->icon}"));
            $icon = Files::moveFile($this->icon, 'Images/Icons');
            $data['icon'] = $icon;
        }
        $category->update($data);
        return $this->generalResponse($category, 'Updated Successfully', 200);
    }
}
