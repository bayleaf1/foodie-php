<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSystemUserRequest;
use App\Http\Requests\UpdateSystemUserRequest;
use App\Models\SystemUser;

class SystemUserController extends Controller
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
    public function store(StoreSystemUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemUser $systemUser)
    {
        //
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
