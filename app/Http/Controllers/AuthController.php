<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    public function __construct()
    {

        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        /*     $token = Auth::attempt($credentials);
        if (!$token) {
            if (!User::where('email', $credentials['email'])->first())
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email does not exist',
                ], 401);
            else
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password incorrect',
                ], 401);
        }
 */
        // $user = Auth::user();
        $data = [
            'grant_type' => 'password',
            'client_id' => '9826f2c4-dc55-4c87-b7e6-b23aabd9f199',
            'client_secret' => 'b4BhfQtY2goAa2GnjeoWKTnw1qf4sfLfWy3MIIyc',
            'username' => $credentials['email'],
            'password' => $credentials['password'],
            'scope' => '',
        ];
        $response = Request::create('/oauth/token', 'POST', $data);
        return app()->handle($response);
        /* return response()->json([
            'status' => 'success',  
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]); */
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'USER',
            'status' => 'ACTIVATED'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
        ]);
    }

    public function logout()
    {
        // Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function verifyToken()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user()
        ], 200);
    }
}
