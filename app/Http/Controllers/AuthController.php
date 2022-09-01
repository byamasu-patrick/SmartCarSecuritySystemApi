<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'phone' => 'required|string|min:10|max:15',
            'location' => 'required|string|min:3|max:100',
            'profile' => 'required|string|string|max:255',
            'title' => 'required|string|string|min:5|max:255',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'confirm_state' => $request->confirm_state,
            'profile' => $request->profile,
            'title' => $request->title,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
                "message" => "User account successfully created",
                "user" => $user
        ], 200);
    }
    /**
     * Log the user in (Validate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }
    public function profile()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

}
