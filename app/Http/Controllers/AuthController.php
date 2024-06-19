<?php

namespace App\Http\Controllers;

use App\Models\SystemUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|string|unique:system_users',
            'password' => 'required|string|min:8',
            'c_password' => 'required|same:password',
            'role' => 'required|in:root,manager'
        ]);

        $user = new SystemUser([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($user->save()) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'message' => 'Successfully created user!',
                'accessToken' => $token,
                "system_user_id" => $user->id,
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = SystemUser::where('email', $request->email)->first();

        if (is_null($user)) {
            return response()->json(['error' => ["message" => "User not found"], "errors" => ["email" => ["User not found with this email"],],], 422);
        }

        if (Hash::check($request->password, $user->password)) {
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->plainTextToken;

            return response()->json([
                'accessToken' => $token,
            ], 201);
        } else {
            return response()->json(['error' => ["message" => "Wrong password"], "errors" => ["password" => ["Wrong password"],],], 422);
        }
    }
}
