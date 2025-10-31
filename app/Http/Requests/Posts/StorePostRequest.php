<?php

namespace App\Http\Requests\Posts;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Files;

class StorePostRequest extends FormRequest
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
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'user_id' => $this->get_validation(),
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:1000'],
            'columns' => ['required', 'array'],
            'columns.*' => ['string'],
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:png,jpg', 'max:5120'],
            'videos' => ['required', 'array'],
            'videos.*' => ['file', 'mimes:mp4,m4a', 'max:5120'],
        ];
    }

    private function get_validation(): string
    {
        if ($this->user()->role === 'office') {
            return 'required|integer|exists:users,id';
        }

        return 'nullable';
    }

    public function store() {
        $data = $this->validated();
        if(! isset($data['user_id'])) {
            $data['user_id'] = $this->user()->id;
        } else {
            if(!in_array($this->user_id, $this->user()->office->employees()->pluck('user_id')->toArray())) {
                return $this->generalResponse(null, 'error_400', 400);
            }
        }

        $columns = $data['columns'];
        $filters = [];
        foreach($columns as $column) {
            $column = explode(",", $column);
            $filters[$column[0]] = $column[1];
        }
        $filters['listing_date'] = now()->format('Y-m-d');
        $data['columns'] = json_encode($filters);

        $images = $data['images'];
        $data['images'] = [];
        foreach($images as $image) {
            $data['images'][] = Files::moveFile($image, "Images/Posts");
        }
        $data['images'] = implode(",", $data['images']);

        $videos = $data['videos'];
        $data['videos'] = [];
        foreach($videos as $video) {
            $data['videos'][] = Files::moveFile($video, "Videos/Posts");
        }
        $data['videos'] = implode(",", $data['videos']);

        Post::create($data);
        return $this->generalResponse(null, '201', 201);
    }

}
