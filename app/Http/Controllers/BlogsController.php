<?php

namespace App\Http\Controllers;

use App\Http\Requests\Dashboard\Blogs\{
    DeleteBlogRequest,
    StoreBlogRequest
};
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Traits\Files;

class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(Blog::latest()->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteBlogRequest $request, Blog $blog)
    {
        $blog->delete();
        Files::deleteFile(public_path('Images/Blogs' . '/' . $blog->image));
        return $this->generalResponse(null, 'Deleted Successfully', 200);
    }
}
