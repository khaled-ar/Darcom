<?php

namespace App\Http\Controllers;

use App\Models\PostComparison;
use Illuminate\Http\Request;

class PostsComparisonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(request()->user()->posts_comparisons()->get()
            ->map(function($posts_comparison) {
                $posts_comparison->post->makeHidden(['images_urls', 'videos_urls', 'columns_values', 'in_favorite']);
                return $posts_comparison;
            })
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post_id = $request->validate(['post_id' => ['required', 'integer', 'exists:posts,id']])['post_id'];
        $user = $request->user();
        if($user->posts_comparisons()->count() >= 3) {
            return $this->generalResponse(null, 'No more than three posts can be added.', 400);
        }
        PostComparison::create(['user_id' => $user->id, 'post_id' => $post_id]);
        return $this->generalResponse(null, '201', 201);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostComparison $posts_comparison)
    {
        $posts_comparison->delete();
        return $this->generalResponse(null, null, 200);
    }

    public function delete_all(Request $request)
    {
        $request->user()->posts_comparisons()->delete();
        return $this->generalResponse(null, null, 200);
    }
}
