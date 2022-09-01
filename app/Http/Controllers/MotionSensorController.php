<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarInfo;
use App\Models\MotionSensor;
use Illuminate\Support\Facades\Validator;

class MotionSensorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api',  ['except' => [ 'create']]);
    }
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $car_info = CarInfo::where('id', $request->car_id)->first();

        return response()->json($car_info->motion_sensors, 200);
    }

    public function single_motion_sensor(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $motion_sensor = MotionSensor::where('id', request("id"))->first();

        return response()->json($motion_sensor, 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sensor_data' => 'required',
            'car_id' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $carinfo = CarInfo::where('id', $request->car_id)->first();

        $carinfo->motion_sensors()->create([
            'sensor_data' => $request->sensor_data,
            'car_id' => $request->car_id
        ]);

        return response()->json([
            'message' => 'Sensor data successfully saved'
        ], 200);
    }
}
