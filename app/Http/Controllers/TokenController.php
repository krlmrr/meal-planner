<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class TokenController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($request->device_name);

        $plainText = ltrim(stristr($token->plainTextToken, '|'),'|');

        return response([
            'message' => 'This is the last time you will see the token below in plain text, make sure you store it in a safe place.',
            'id' => $token->accessToken['id'],
            'name' => $token->accessToken['name'],
            'token' => $plainText,
            'hashed_token' => $token->accessToken['token']
        ], 201);
    }

    public function destroy(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $user->tokens()->where('id', $request->tokenId)->delete();

            return response([
                'message' => 'Token Revoked'
            ], 204);
        };
    }
}