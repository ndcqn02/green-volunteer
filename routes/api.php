<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('auth')->group(function () {
    Route::post('register', [UserController::class,'register']);
    Route::post('login', [UserController::class,'login']);
    Route::get('/google/redirect', [UserController::class,'redirectToAuth']);
    Route::get('/google/callback/', [UserController::class, 'handleGoogleCallback']);
});

Route::prefix('user')->group(function () {
    Route::put("/updateUser",[UserController::class,"updateUser"]);
});

Route::prefix('activities')->group(function () {
    Route::post('/', [ActivityController::class,'create']);
    Route::put('/', [ActivityController::class,'update']);
    Route::delete('/{id}', [ActivityController::class,'delete']);
    Route::get('/',[ActivityController::class,'index']);
    Route::get('/{id}', [ActivityController::class,'show']);
});
