<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index']);
    Route::post('/', [ClientController::class, 'store']);
    Route::get('{client}', [ClientController::class, 'show']);
    Route::put('{client}', [ClientController::class, 'update']);
    Route::delete('{client}', [ClientController::class, 'destroy']);

    Route::get('{client}/favorites', [FavoriteController::class, 'index']);
    Route::post('{client}/favorites', [FavoriteController::class, 'store']);
    Route::delete('{client}/favorites/{productId}', [FavoriteController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);       // lista todos os produtos
    Route::get('{id}', [ProductController::class, 'show']);     // detalhe de produto por ID
});

