<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', ['as' => 'login', AuthController::class, 'login']);

Route::post('/hammingdistance', function (Request $req) {
    $req->validate(['x' => 'integer|gte:0|lt:' . pow(2, 31), 'y' => 'integer|gte:0|lt:' . pow(2, 31)]);    
    return response(substr_count(decbin($req->x ^ $req->y), "1"), 200);
});
