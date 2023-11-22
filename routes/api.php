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
    Route::get('/google/callback/', [UserController::class, 'handleGoogleCallback']);
});

Route::prefix('user')->group(function () {
    Route::put("/updateUser",[UserController::class,"updateUser"]);
});

// Route::prefix('activities')->group(function () {
//     Route::post('/', [ActivityController::class,'create']);
//     Route::put('/', [ActivityController::class,'update']);
//     Route::delete('/{id}', [ActivityController::class,'delete']);
//     Route::get('/',[ActivityController::class,'index']);
//     Route::get('/{status}', [ActivityController::class,'index']);
//     Route::get('getId/{id}', [ActivityController::class,'show']);
// });
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');


Route::prefix('posts')->group(function () {
    Route::get('/',[PostController::class,'index']);
    Route::get('/{status}', [PostController::class,'index']);
    Route::get('getId/{id}', [PostController::class,'show']);
    Route::post('/', [PostController::class,'create']);
    Route::put('/', [PostController::class,'update']);
    Route::delete('/{id}', [PostController::class,'delete']);

});
Route::prefix('forms')->group(function () {
    Route::get('/',[FormsController::class,'index']);
    Route::get('/{status}', [FormsController::class,'index']);
    Route::get('getId/{id}', [FormsController::class,'show']);
    Route::post('/', [FormsController::class,'create']);
    Route::put('/', [FormsController::class,'update']);
    Route::delete('/{id}', [FormsController::class,'delete']);

});
