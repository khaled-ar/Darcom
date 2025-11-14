<?php

namespace App\Http\Controllers;

use App\Models\Path;
use Illuminate\Http\Request;

class PathsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->generalResponse(request()->user()->paths);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'exists:categories,name'],
            'type' => ['required', 'string'],
            'min_price' => ['required', 'numeric'],
            'max_price' => ['required', 'numeric'],
            'currency' => ['required', 'string', 'max:3'],
            'min_space' => ['required', 'integer'],
            'max_space' => ['required', 'integer'],
            'city' => ['required', 'string', 'exists:cities,city'],
        ]);
        $data['user_id'] = $request->user()->id;
        $path = Path::create($data);
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
    public function destroy(Path $path)
    {
        $path->delete();
        return $this->generalResponse(null, null, 200);
    }
}
