<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestObatController;
use App\Http\Controllers\ObatController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::put('/request-obat/{id}', [RequestObatController::class, 'responseAdmin']);

        Route::get('/request-obat', [RequestObatController::class, 'listRequest']);
 
        Route::post("/obat", [ObatController::class, 'create']);
        Route::delete('/obat/{id}', [ObatController::class, 'delete']);
    });
    Route::middleware('role:distributor')->prefix('/distributor')->group(function () {
        Route::put('/request-obat/{id}', [RequestObatController::class, 'responseDistributor']);
        Route::get('/obat', [RequestObatController::class, 'listObatDistributor']);
    });
    Route::middleware('role:external')->prefix('/external')->group(function () {
        Route::post('/request-obat', [RequestObatController::class, 'requestObatAction']);
        Route::get('/request-obat', [RequestObatController::class, 'listObatExternal']);
    });
    Route::get('/obat', [ObatController::class, 'index']);
    Route::get('/obat/expired', [ObatController::class, 'expiredObatData']);
    Route::get('/obat/stock', [ObatController::class, 'stockObat']);
});