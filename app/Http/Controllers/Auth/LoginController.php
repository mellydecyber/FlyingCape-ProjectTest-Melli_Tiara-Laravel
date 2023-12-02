<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseApiController
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token Kiddo');
        $token = $tokenResult->plainTextToken;

        return $this->sendSuccess([
            'accessToken' => $token,
            'token_type' => 'Bearer',
        ], ['message' => 'Successfully login']);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->sendSuccess([], ['message' => 'Successfully logged out']);
    }
}
