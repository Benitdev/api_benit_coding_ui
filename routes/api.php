<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\FilterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('verify-token', 'verifyToken');
    });
});
Route::prefix('cards')->group(function () {
    Route::controller(CardController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/home-card', 'getHomeCard');
        Route::get('/{card}', 'show');
        Route::post('/add-card', 'store');
        Route::put('/edit-card/{id}', 'update');
    });
});
Route::prefix('filter')->group(function () {
    Route::controller(FilterController::class)->group(function () {
        Route::get('/', 'index');
    });
});
