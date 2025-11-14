<?php

namespace App\Http\Controllers;

use App\Models\PostsRequest;
use Illuminate\Http\Request;

class PostsRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'exists:categories,name'],
            'min_price' => ['required', 'numeric'],
            'max_price' => ['required', 'numeric'],
            'min_space' => ['required', 'integer'],
            'max_space' => ['required', 'integer'],
            'type' => ['required', 'string'],
            'description' => ['string', 'max:150'],
        ]);
        $data['user_id'] = $request->user()->id;
        $request = PostsRequest::create($data);
        return $this->generalResponse(null, null, 200);
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
        //
    }
}
