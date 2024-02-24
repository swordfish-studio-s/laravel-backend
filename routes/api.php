<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AdminController;
use Nette\Utils\Json;

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


Route::get('/', [PostController::class, 'index'])->name('home')->middleware('guest')->middleware('throttle:5,1');

Route::get('posts/{post:slug}', [PostController::class, 'show'])->where('posts','[A-z_\-]+')->middleware('throttle:5,1');

Route::get('register', [RegisterController::class, 'create'])->middleware('guest')->middleware('throttle:5,1');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest')->middleware('throttle:5,1');

Route::post('logout', [SessionController::class, 'destroy'])->middleware('auth')->middleware('throttle:5,1');

Route::post('sessions', [SessionController::class, 'store'])->middleware('guest')->middleware('throttle:5,1');
Route::get('login', [SessionController::class, 'create'])->middleware('guest')->middleware('throttle:5,1');

Route::middleware('can:admin')->group(function () {

    Route::post('admin/posts', [AdminController::class, 'store']);
    Route::get('admin/posts/create', [AdminController::class, 'create']);
    Route::get('admin/posts', [AdminController::class, 'index']);
    Route::get('admin/posts/{post}/edit', [AdminController::class, 'edit']);
    Route::patch('admin/posts/{post}', [AdminController::class, 'update']);
    Route::delete('admin/posts/{post}', [AdminController::class, 'destroy']);

})->middleware('throttle:5,1');




Route::middleware('auth:sanctum')->get('/user/{id}', function (Request $request) {
    return $request->user();
});
