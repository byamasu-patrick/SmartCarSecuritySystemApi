<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarInfo;
use App\Models\AlertInfo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlertController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api',  ['except' => [ 'create']]);
    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_info_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = CarInfo::where('id', $request->car_info_id)->first();

        return response()->json($user->alert_infos, 200);
    }

    public function single_alert_info(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $alert_info = AlertInfo::where('id', request("id"))->first();

        return response()->json($alert_info, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'picture' => 'required',
            'description' => 'required',
            'alarm_state' => 'required',
            'car_info_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $car = CarInfo::where('id', $request->input('car_info_id'))->first();

        $car->alert_infos()->create([
            'description' => $request->input('description'),
            'alarm_state' => (bool) $request->input('alarm_state'),
            'picture' => $request->input('picture')
        ]);

        return response()->json([
            'message' => 'Alert info successfully created'
        ], 200);
    }
}
