<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use app\Http\Controllers\Controller;

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
});

Route::prefix('user')->group(function () {
    Route::put("/updateUser",[UserController::class,"updateUser"]);
});

Route::prefix('activities')->group(function () {
    Route::post('/', [ActivityController::class,'create']);
    Route::put('/', [ActivityController::class,'update']);
    Route::delete('/{id}', [ActivityController::class,'delete']);
    Route::get('/',[ActivityController::class,'index']);
    Route::get('/{status}', [ActivityController::class,'index']);
    Route::get('getId/{id}', [ActivityController::class,'show']);
});
Route::prefix('posts')->group(function () {
    Route::get('/{status}', [PostController::class,'index']);
    Route::get('getId/{id}', [PostController::class,'show']);
    Route::post('/', [PostController::class,'create']);
    Route::put('/{id}', [PostController::class,'update']);
    Route::delete('/{id}', [PostController::class,'delete']);

});
Route::prefix('form')->group(function () {
    Route::get('/',[FormController::class,'index']);
    Route::get('/{status}', [FormController::class,'index']);
    Route::get('getId/{id}', [FormController::class,'show']);
    Route::post('/', [FormController::class,'create']);
    Route::put('/{id}', [FormController::class,'update']);
    Route::delete('/{id}', [FormController::class,'delete']);

});
