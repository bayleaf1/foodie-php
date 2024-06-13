<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\Resource;
use Ramsey\Uuid\Uuid;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResourceRequest $request)
    {

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = Uuid::uuid4() . '_' . $file->getClientOriginalName();
            $file->move('./resources', $imageName);

            Resource::create(["name" => $imageName, "type" => 'image']);
            return response()->json(['message' => "Uploaded!", "name" => $imageName]);
        } else {
            return response()->json(['message' => 'No image to upload.'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResourceRequest $request, Resource $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        //
    }
}
