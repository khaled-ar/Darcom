<?php

namespace App\Http\Requests\Posts;

use App\Models\Reason;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\Files;

class UpdatePostRequest extends FormRequest
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
            'title' => ['string', 'max:100'],
            'description' => ['string', 'max:1000'],
            'columns' => ['array'],
            'columns.*' => ['string'],
            'reason' => $this->get_validation(),
            // 'images' => ['array'],
            // 'images.*' => ['image', 'mimes:png,jpg', 'max:5120'],
            // 'videos' => ['array'],
            // 'videos.*' => ['file', 'mimes:mp4,m4a', 'max:5120'],
        ];
    }

    private function get_validation(): string
    {
        if ($this->user()->role !== 'admin') {
            return 'required|string|exists:reasons,reason';
        }

        return 'nullable';
    }

    public function update($post) {

        if(request()->user()->role == 'admin') {
            $post->update(['status' => $this->status, 'reason' => $this->reject_reason ?? null]);
            return $this->generalResponse(null, 'Updated Successfully', 200);
        }

        $data = $this->validated();
        $data['status'] = 'to_update';

        if($this->columns) {
            $columns = $data['columns'];
            $current_columns = $post->columns_values;
            foreach($columns as $column) {
                $column = explode(",", $column);
                $current_columns->{$column[0]} = $column[1];
            }
            $data['columns'] = json_encode($current_columns);
        }

        // $images = $data['images'];
        // $data['images'] = [];
        // foreach($images as $image) {
        //     $data['images'][] = Files::moveFile($image, "Images/Posts");
        // }
        // $data['images'] = implode(",", $data['images']);

        // $videos = $data['videos'];
        // $data['videos'] = [];
        // foreach($videos as $video) {
        //     $data['videos'][] = Files::moveFile($video, "Videos/Posts");
        // }
        // $data['videos'] = implode(",", $data['videos']);

        $post->update($data);
        Reason::whereReason($this->reason)->increment('usage_count');
        return $this->generalResponse(null, 'The request has been sent to the manager successfully. The changes will be applied immediately after approval.', 200);
    }
}
