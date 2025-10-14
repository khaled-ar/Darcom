<?php

namespace App\Http\Requests\Dashboard\Categories;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Files;

class StoreCategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100', 'unique:categories,name'],
            'icon' => ['required', 'image', 'mimes:png,jpg', 'max:2048'],
            'filters' => ['string'],
        ];
    }

    public function store() {
        $icon = Files::moveFile($this->icon, 'Images/Icons');
        $data = $this->validated();
        $data['icon'] = $icon;
        $filters = implode(",", (include base_path('app/Data/filters.php'))['common']);
        $filters = $this->filters ? $filters . ',' . $this->filters : $filters;
        $data['filters'] = $filters;
        Category::create($data);
        return $this->generalResponse(null, '201', 201);
    }
}
