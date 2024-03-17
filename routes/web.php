<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeliveryOrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductOrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('do.login');
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('/do', DeliveryOrderController::class);
    Route::resource('/p_order', ProductOrderController::class);

    Route::controller(AjaxController::class)->group(function () {
        Route::get('/ajax/getAreaID', 'getAreaID')->name('ajax.getAreaID');
        Route::get('/ajax/getCourierRate', 'getCourierRate')->name('ajax.getCourierRate');
    });
});
