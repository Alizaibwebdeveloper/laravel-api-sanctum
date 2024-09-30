<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // RegisterApi, loginApi, ProfileApi, LogoutApi

    // post[name, email,password]

    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        // Creating a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully!',
            'data' => $user,  
        ]);
    }

    // post[email, password]
    public function login(Request $request)
{
    // Validation
    $request->validate([
        'email' => 'required|email|string',
        'password' => 'required'
    ]);

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!empty($user)) {
        // Check if the password matches
        if (Hash::check($request->password, $user->password)) { 
            // Generate token
            $token = $user->createToken('mytoken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'Token' => $token,
                'data' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid password',
                'data' => [],
            ]);
        }
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Please provide a valid email and password',
            'data' => [],
        ]);
    }
}

   

    // GET [Auth:token]
    public function profile()
    {
        $userData = auth()->user();
        return response()->json([

         'status'=> true,
         'message'=> 'user profile information',
         'data'=> $userData,
        ]);
    }

    // GET [Auth:token]
    public function logout()
    {
      auth()->user()->tokens()->delete();
      return response()->json([
         'status'=> true,
         'message'=> 'user Logout',
         'data'=>[]
      ]);
    }
}
