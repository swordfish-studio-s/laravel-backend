<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user/{id}', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function () {
    // Route::post('/signin', [UserAuthController::class, 'authenticate'])->middleware('throttle:5,1');
    // Route::post('/signup', [UserAuthController::class, 'register'])->middleware('throttle:5,1');
});

Route::get('/', function () {
    return response()->json([
        'message' => 'connectie gemaakt',
        'status' => Response::HTTP_OK,
    ])->middleware('throttle:5,1');
});
