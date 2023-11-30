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
    Route::get('/google/redirect', [UserController::class,'redirectToAuth']);
    Route::get('/facebook/redirect', [UserController::class,'redirectToFacebook']);
    Route::get('/google/callback/', [UserController::class, 'handleGoogleCallback']);
    Route::get('/facebook/callback/', [UserController::class, 'handleFacebookCallback']);
});

Route::prefix('user')->group(function () {
    Route::put("/updateUser",[UserController::class,"updateUser"])->middleware("jwt_auth");
});

Route::prefix('activities')->group(function () {
    Route::post('/', [ActivityController::class,'store'])->middleware("jwt_auth");
    Route::put('/', [ActivityController::class,'update'])->middleware("jwt_auth");
    Route::delete('/{id}', [ActivityController::class,'delete'])->middleware("jwt_auth");
    Route::get('/',[ActivityController::class,'index']);
    Route::get('/{status}', [ActivityController::class,'index'])->middleware("jwt_auth");
    Route::get('getId/{id}', [ActivityController::class,'show'])->middleware("jwt_auth");
});

Route::prefix('posts')->group(function () {
    Route::get('/',[PostController::class,'index']);
    Route::get('/{status}', [PostController::class,'index'])->middleware("jwt_auth");
    Route::get('getId/{id}', [PostController::class,'show'])->middleware("jwt_auth");
    Route::post('/', [PostController::class,'create'])->middleware("jwt_auth");
    Route::put('/', [PostController::class,'update'])->middleware("jwt_auth");
    Route::delete('/{id}', [PostController::class,'delete'])->middleware("jwt_auth");

});
Route::prefix('forms')->group(function () {
    Route::get('/',[FormsController::class,'index']);
    Route::get('/{status}', [FormsController::class,'index'])->middleware("jwt_auth");
    Route::get('getId/{id}', [FormsController::class,'show'])->middleware("jwt_auth");
    Route::post('/', [FormsController::class,'create'])->middleware("jwt_auth");
    Route::put('/', [FormsController::class,'update'])->middleware("jwt_auth");
    Route::delete('/{id}', [FormsController::class,'delete'])->middleware("jwt_auth");

});

Route::prefix("vnpay")->group(function () {
    Route::post("/",[VnPayController::class,"vnpay"]);
});
