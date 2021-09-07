<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
| ここでは、アプリケーションのWebルートを登録することができます。これらの
| ミドルウェアグループ "web "を含むグループ内のRouteServiceProviderによって読み込まれます。さあ、素敵な作品を作りましょう
*/

Route::get('/', function () {
    return view('welcome');
});
