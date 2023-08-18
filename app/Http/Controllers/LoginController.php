<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $credentials = $request->only('email', 'password');
        if (Auth::guard()->attempt($credentials)) {
            $user = $request->user();
            $token = $user->createToken('user_token');
            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken
            ]);
        }
        // dd($isLoged);Ç{ }}
    }
}
