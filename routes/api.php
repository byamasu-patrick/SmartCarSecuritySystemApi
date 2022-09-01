<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GrantedUserController;
use App\Http\Controllers\CarInfoController;
use App\Http\Controllers\MotionSensorController;
use App\Http\Controllers\AlertController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/profile', [AuthController::class, 'profile']);

    // Define for granted user
    Route::post('/granted-user/create', [GrantedUserController::class, 'create']);
    Route::get('/granted-user/user', [GrantedUserController::class, 'index']);
    Route::get('/grated-user', [GrantedUserController::class, 'single_granted_user']);
    // Car for a registered user
    Route::post('/car-info/create', [CarInfoController::class, 'create']);
    Route::post('/car-info/user_update', [CarInfoController::class, 'update_user']);
    Route::get('/car-info/car_get', [CarInfoController::class, 'car_get']);
    Route::get('/car-info/get_user', [CarInfoController::class, 'get_user']);
    Route::get('/car-info/user', [CarInfoController::class, 'index']);
    Route::get('/car-info', [CarInfoController::class, 'single_car_info']);

    // Motion sensor
    Route::post('/motion-sensor/create', [MotionSensorController::class, 'create']);
    Route::post('/motion-sensor', [MotionSensorController::class, 'index']);
    Route::get('/motion-sensor', [MotionSensorController::class, 'single_motion_sensor']);
     // Motion sensor
     
     Route::post('/alert_info/create', [AlertController::class, 'create']);
     Route::post('/alert_info', [AlertController::class, 'index']);
     Route::get('/alert_info', [AlertController::class, 'single_alert_info']);
    
});

// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {
//     Route::post('register', 'AuthController@register');
//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });