<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'media'],function(){
    Route::get('/get/profile/image/{user_id}/{file}',[MediaController::class,'getMediaProfile'])->name('media.profile.get');
});
Route::get('/sociallogin/google', [AuthController::class, 'SocialSignup']);
Route::get('/auth/callback', [AuthController::class, 'callBack']);
