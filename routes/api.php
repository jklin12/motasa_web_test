<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DeliveryOrderController;
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

Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::controller(DeliveryOrderController::class)->group(function () {
        Route::get('/do', 'index');
        Route::get('/do/{id}', 'show');
        Route::put('/do/{id}', 'update');
        
    });
});
