<?php

use App\Http\Controllers\v1\GateController;
use App\Http\Controllers\v1\ParkingSpaceController;
use App\Http\Controllers\v1\VehicleTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function(){
    Route::get('/parking/spaces', [ParkingSpaceController::class, 'getParkingSpaces']);
    Route::post('/parking/create', [ParkingSpaceController::class, 'createParkingSpace']);
    Route::put('/parking/park', [ParkingSpaceController::class, 'parkVehicle']);
    Route::put('/parking/unpark', [ParkingSpaceController::class, 'unparkVehicle']);

    Route::get('/gate/get', [GateController::class, 'getGates']);
    Route::post('/gate/create', [GateController::class, 'createGate']);
    Route::delete('/gate/delete', [GateController::class, 'deleteGate']);

    Route::get('/vehicle-type/get', [VehicleTypeController::class, 'getVehicleTypes']);
});