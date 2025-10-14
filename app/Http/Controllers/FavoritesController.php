<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(request()->user()->favorites->load(['post.user']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['post_id' => ['required', 'integer', 'exists:posts,id']]);
        request()->user()->favorites()->create(['post_id' => $request->post_id]);
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
    public function destroy(string $id)
    {
        request()->user()->favorites()->where('post_id', $id)->delete();
        return $this->generalResponse(null, 'Deleted Successfully', 200);
    }
}
