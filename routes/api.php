<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::get("/polls", [PollController::class, 'get_polls']);
Route::prefix('/poll')->group(function () {
	Route::post('/', [PollController::class, 'create']);
	Route::get('/{id}', [PollController::class, 'index']);
	Route::post('/{id}/vote', [PollController::class, 'vote']);
	Route::get('/{id}/stats', [PollController::class, 'stats']);
});
