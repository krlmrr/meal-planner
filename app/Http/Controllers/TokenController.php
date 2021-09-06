<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Sanctum;

class TokenController extends Controller
{
    public function index()
    {
        if(Auth::guard('sanctum')) {
            $tokens = Auth::guard('sanctum')->user()->tokens()->get();

            if(count($tokens) > 0) {
                return response($tokens, 200);
            }
        }

        return response([
            'message' => 'No Tokens Found'
        ], 404);
    }

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

        $plainTextToken = ltrim(stristr($token->plainTextToken, '|'),'|');

        return response([
            'message' => 'This is the last time you will see the token below in plain text, make sure you store it in a safe place.',
            'id' => $token->accessToken['id'],
            'name' => $token->accessToken['name'],
            'token' => $plainTextToken,
            'hashed_token' => $token->accessToken['token']
        ], 201);
    }

    public function destroy(Request $request)
    {
        if(Auth::guard('sanctum')) {

            $token = Auth::guard('sanctum')->user()->tokens()->where('id', $request->id)->get();

            if (count($token) > 0) {
                Auth::guard('sanctum')->user()->tokens()->where('id', $request->id)->delete();
                return response([
                    'message' => 'Token Revoked'
                ], 200);
            };
        }

        return response(['message' => 'Could not be deleted']);
    }
}
