<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\{
    StorePostRequest,
    UpdatePostRequest
};
use App\Models\{
    Post,
    Reason
};
use App\Traits\Files;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = request()->user();

        if($user->role == 'employee' || ($user->role == 'general_user' && request('my'))) {
            return $this->generalResponse($user->posts);
        }

        if($user->role == 'general_user') {
            $posts = Post::filters()->category()->whereStatus('active')->with('user')->latest()->get()
            ->map(function($post) {
                $post->create_date = $post->created_at->format('Y-m-d');
                $post->publisher = [
                    'name' => $post->user->general_user ? $post->user->general_user->fullname : $post->user->employee->fullname,
                    'whatsapp' => $post->user->whatsapp,
                    'phone' => $post->user->whatsapp,
                    'role' => $post->user->role,
                    'image_url' => $post->user->role == 'general_user' ? $post->user->general_user->image_url : $post->user->employee->image_url,
                ];
                unset($post->user);
                return $post;
            });
            return $this->generalResponse($posts);
        }

        if($user->role == 'office') {
            if(request('my')) {
                $employees = $user->office->employees->pluck('user_id');
                $posts = Post::whereIn('user_id', $employees)->with('user')->get();
                return $this->generalResponse($posts);
            }
            $posts = Post::filters()->category()->whereStatus('active')->with('user')->latest()->get()
            ->map(function($post) {
                $post->create_date = $post->created_at->format('Y-m-d');
                $post->publisher = [
                    'name' => $post->user->general_user ? $post->user->general_user->fullname : $post->user->employee->fullname,
                    'whatsapp' => $post->user->whatsapp,
                    'phone' => $post->user->whatsapp,
                    'role' => $post->user->role,
                    'image_url' => $post->user->role == 'general_user' ? $post->user->general_user->image_url : $post->user->employee->image_url,
                ];
                unset($post->user);
                return $post;
            });
            return $this->generalResponse($posts);
        }

        return $this->generalResponse(Post::category()->whereStatus(request('status'))->with('user')->get());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        return $request->store();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        return $request->update($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user = request()->user();
        if($user->role != 'admin') {
            $reason = request()->validate(['reason' => ['required', 'string', 'exists:reasons,reason']]);
            $post->update(['status' => 'to_delete', 'reason' => $reason['reason']]);
            Reason::whereReason($reason['reason'])->increment('usage_count');
            return $this->generalResponse(null, 'The request has been sent to the manager successfully. The changes will be applied immediately after approval.', 200);
        }

        if(request('approve') == 1) {
            if($post->images) {
                foreach(explode(",", $post->images) as $image) {
                    Files::deleteFile(public_path("Images/Posts/{$image}"));
                }
            }

            if($post->videos) {
                foreach(explode(",", $post->videos) as $video) {
                    Files::deleteFile(public_path("Videos/Posts/{$video}"));
                }
            }
            $post->delete();
            return $this->generalResponse(null, 'Deleted Successfully', 200);
        }

        $post->update(['status' => 'active', 'reason' => request('reject_reason') ?? null]);
        return $this->generalResponse(null, 'Updated Successfully', 200);

    }

    public function get_publisher(Post $post) {
        $publisher = $post->user;
        $posts = $publisher->posts;
        if($publisher->role == 'employee') {
            $user = $publisher->employee->office->load(['work_times', 'social_links']);
        } else {
            $user = $publisher->general_user;
        }
        return $this->generalResponse([
            'user' => $user,
            'posts' => $posts
        ]);
    }
}
