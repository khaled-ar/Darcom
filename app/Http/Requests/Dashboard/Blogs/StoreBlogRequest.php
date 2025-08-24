<?php

namespace App\Http\Requests\Dashboard\Blogs;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Files;

class StoreBlogRequest extends FormRequest
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
            'text' => ['sometimes', 'string', 'max:5000'],
            'image' => ['sometimes', 'image', 'mimes:png,jpg', 'max:2048'],
        ];
    }

    public function store() {
        if(is_null($this->text) && is_null($this->image)) {
            return $this->generalResponse(null, 'error_400', 400);
        }

        $blog = Blog::create($this->validated());
        if($this->hasFile('image')) {
            $blog->update(['image' => Files::moveFile($this->image, 'Images/Blogs')]);
        }
        return $this->generalResponse(null, '201', 201);
    }
}
