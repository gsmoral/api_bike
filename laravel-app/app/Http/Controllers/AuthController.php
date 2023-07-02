<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * API Login
     */
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);
    
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('API Token')->plainTextToken;

                return response()->json([
                    'status'=> true,
                    'token' => $token
                ], 200);
            } else {
                return response()->json([
                    'status'=> false,
                    'error' => 'Unauthorized'
                ], 401);
            }

        } catch (ValidationException $exception) {
            return response()->json([
                'status' => false,
                'errors' => $exception->errors()
            ], 400);
        }
    }
}
