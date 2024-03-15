<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

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


//Route::get('/', [PostController::class, 'index'])->name('home')->middleware('guest')->middleware('throttle:5,1');

Route::post('signup',[UserController::class, 'signup'])->middleware('throttle:5,1');
Route::post('signin',[UserController::class, 'signup'])->middleware('throttle:5,1');
Route::get('me', [UserController::class, 'me'])->middleware('throttle:5,1')->middleware('jwt.auth');
Route::post('logout', [UserController::class, 'logout'])->middleware('throttle:5,1')->middleware('jwt.auth');


Route::prefix('admin')->group(function () {
Route::get('data', [PostController::class, 'show'])->middleware('jwt.auth')->middleware('throttle:5,1');
Route::post('create', [PostController::class, 'create'])->middleware('jwt.auth')->middleware('throttle:5,1');
Route::post('update', [PostController::class, 'update'])->middleware('jwt.auth')->middleware('throttle:5,1');
Route::post('delete', [PostController::class, 'delete'])->middleware('jwt.auth')->middleware('throttle:5,1');
});

Route::prefix('user')->group(function () {
    Route::get('data', [PostController::class, 'show'])->middleware('jwt.auth')->middleware('throttle:5,1');
    Route::post('create', [PostController::class, 'create'])->middleware('jwt.auth')->middleware('throttle:5,1');
    Route::post('update', [PostController::class, 'update'])->middleware('jwt.auth')->middleware('throttle:5,1');
    Route::post('delete', [PostController::class, 'delete'])->middleware('jwt.auth')->middleware('throttle:5,1');
});


// Route::middleware('can:admin')->group(function () {

//     Route::post('admin/posts', [AdminController::class, 'store']);
//     Route::get('admin/posts/create', [AdminController::class, 'create']);
//     Route::get('admin/posts', [AdminController::class, 'index']);
//     Route::get('admin/posts/{post}/edit', [AdminController::class, 'edit']);
//     Route::patch('admin/posts/{post}', [AdminController::class, 'update']);
//     Route::delete('admin/posts/{post}', [AdminController::class, 'destroy']);

// })->middleware('throttle:5,1');
