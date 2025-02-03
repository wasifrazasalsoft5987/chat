<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

class AuthController extends MainController
{
    public function signup(Request $request)
    {
        User::create($request->all());
        return $this->response->successMessage("register successfully!");
    }

    public function login(Request $request)
    {
        if (auth()->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $token = $request->user()->createToken('main')->plainTextToken;
            return $this->response->success([
                'user' => auth()->user(),
                'access_token' => $token
            ]);
        }
        throw new AuthenticationException("Invalid email or password.");
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->response->successMessage("logout successfully!");
    }
}
