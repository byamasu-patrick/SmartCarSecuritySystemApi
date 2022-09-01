<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\CarInfo;

class CarInfoController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [ 'car_get', 'get_user', 'update_user']]);
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

        return response()->json($user->car_infos, 200);
    }

    public function single_car_info(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car_info = CarInfo::where('id', request("id"))->first();

        return response()->json($car_info, 200);
    }
    public function car_get(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'car_serial_number' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car_info = CarInfo::where('car_serial_number', request("car_serial_number"))->first();

        return response()->json($car_info, 200);
    }
    public function get_user(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('id', request("user_id"))->first();

        return response()->json($user, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_type' => 'required|string|min:2|max:100',
            'car_serial_number' => 'required|string|min:3|max:20',
            'car_profile' => 'required',
            'user_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::where('id', $request->user_id)->first();

        $user->car_infos()->create([
            'car_type' => $request->car_type,
            'car_serial_number' => $request->car_serial_number,
            'car_profile' => $request->car_profile
        ]);

        return response()->json([
            'message' => 'Car was successfully granted',
            'car' => $user->car_infos
        ], 200);
    }
    public function update_user(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->profile = $request->profile;
        $user->save();

        return response()->json([
            'message' => 'User was successfully updated'
        ], 200);
    }
}
