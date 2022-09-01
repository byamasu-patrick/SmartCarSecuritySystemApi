<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GrantedUser;
use Illuminate\Support\Facades\Validator;

class GrantedUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('id', $request->user_id)->first();

        return response()->json($user->granted_users, 200);
    }

    public function single_granted_user(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $granted_user = GrantedUser::where('id', request("id"))->first();

        return response()->json($granted_user, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|min:2|max:100',
            'granted_state' => 'required',
            'profile' => 'required',
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('id', (int) $request->user_id)->first();

        $user->granted_users()->create([
            'fullname' => $request->fullname,
            'granted_state' => (bool) $request->granted_state,
            'profile' => $request->profile
        ]);

        return response()->json([
            'message' => 'User successfully granted',
            'granted_user' => $user->granted_users
        ], 200);
    }
}

