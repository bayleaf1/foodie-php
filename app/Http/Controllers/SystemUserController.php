<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSystemUserRequest;
use App\Http\Requests\UpdateSystemUserRequest;
use App\Models\SystemUser;
use App\Utils\SystemUserTableFetcher;
use Illuminate\Http\Request;

class SystemUserController extends Controller
{


    public function table()
    {
        $f = new SystemUserTableFetcher();
        $table = $f->get(request()->query());

        return response()->json([
            "table" => $table,
        ]);

    }

    public function getProfile(Request $request)
    {
        return response()->json(["profile" => $request->user()->toJson()]);
    }
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
    public function store(StoreSystemUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemUser $systemUser)
    {
        // return response()->json(["profile" => $systemUser->toJson(),]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SystemUser $systemUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemUserRequest $request, SystemUser $systemUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SystemUser $systemUser)
    {
        //
    }
}
