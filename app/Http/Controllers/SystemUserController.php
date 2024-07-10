<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSystemUserRequest;
use App\Http\Requests\UpdateSystemUserRequest;
use App\Models\SystemUser;
use App\Utils\SystemUserTableFetcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SystemUserController extends Controller
{


    public function profile($id)
    {
        $user = SystemUser::find($id);
        return response()->json(["profile" => $user->toArray()]);

    }

    public function table()
    {
        $f = new SystemUserTableFetcher();
        $table = $f->get(request()->all());

        return response()->json([
            "table" => $table,
        ]);

    }

    public function me(Request $request)
    {
        return response()->json(["profile" => $request->user()->toArray()]);
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
        return response()->json(["profile" => $systemUser->toJson(),]);

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
        $body = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string',
            'role' => 'required|in:root,manager',
            'password' => 'nullable|string|min:0',
        ]);

        $result = [
            "name" => $body["name"],
            "role" => $body["role"],
        ];
        $system_user = SystemUser::find($request->route('id'));

        if ($body['email'] != $system_user->email)
            $result['email'] = $body['email'];

        if (!is_null($body['password']))
            $result['password'] = Hash::make($body['password']);

        $system_user->update($result);

        return response()->json(["profile" => $system_user->toArray()]);
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
