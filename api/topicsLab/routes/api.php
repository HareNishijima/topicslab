<?php

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
| ここでは、アプリケーションのAPIルートを登録することができます。
| これらのルートは、RouteServiceProviderによって、"api "という
| ミドルウェアグループが割り当てられたグループ内で読み込まれます。APIの構築をお楽しみください。
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [
    App\Http\Controllers\UserController::class,
    'store'
]);

Route::post('/logout', [
    App\Http\Controllers\LoginController::class,
    'logout'
]);

Route::get('/topics', [
    App\Http\Controllers\TopicController::class,
    'index'
]);

//{}で囲まれた部分はルートパラメータ
Route::middleware('auth:sanctum')->get('/topic/{topic}', [
    App\Http\Controllers\TopicController::class,
    'show'
]);

Route::middleware('auth:sanctum')->post('/comment', [
    App\Http\Controllers\CommentController::class,
    'store'
]);

Route::middleware('auth:sanctum')->post('/commentlike', [
    App\Http\Controllers\CommentLikeController::class,
    'store'
]);

Route::middleware('auth:sanctum')->post('/topic', [
    App\Http\Controllers\TopicController::class,
    'store'
]);

Route::middleware('auth:sanctum')->post('/topiclike', [
    App\Http\Controllers\TopiclikeController::class,
    'store'
]);

Route::middleware('auth:sanctum')->get('/user/{user}', [
    App\Http\Controllers\UserController::class,
    'show'
]);
