<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * 
     */
    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt(['email' => $fields['email'], 'password' => $fields['password']])) {
            $user = User::where('email', $fields['email'])->first();            
            $userToken = $user->createToken('token')->plainTextToken;
            return response([
                'user' => $user,
                'userToken' => $userToken
            ], 201);
        }

        return response([
            'message' => 'Bad credentials!'
        ], 401);
    }

    /**
     * 
     */
    public function logout() {
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Token deleted and user logged out!'
        ]);
    }

    /**
     * 
     */
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);    

        return response([
            'user' => $user,
            'message' => 'User created!'
        ], 201);
    }
}
