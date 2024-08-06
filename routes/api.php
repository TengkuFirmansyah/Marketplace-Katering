<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UrlController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\MerchantMenuController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\RoleMenusController;
use App\Http\Controllers\RolePermissionsController;
use App\Http\Controllers\ProfileMahasiswaController;

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

Route::get('/version',function(){
    return app()->version();
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/login_neo', [AuthController::class, 'loginNeo']);
Route::post('/login_neo/callback', [AuthController::class, 'callBackNeo']);

Route::get('/verify_email', [AuthController::class, 'sendEmailReminder']);
Route::get('/verify_email/{id}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/verify_token', [AuthController::class, 'verifyToken']);
Route::post('/verify_token_google', [AuthController::class, 'verifyTokenGoogle']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/sociallogin/google', [AuthController::class, 'SocialSignup']);
Route::get('/auth/callback', [AuthController::class, 'callBack']);

Route::post('forget-password', [AuthController::class, 'submitForgetPasswordForm']); 
Route::post('reset-password', [AuthController::class, 'submitResetPasswordForm']);

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::match(array('GET'),'permissions', [RoleController::class,'permission']);
    Route::get('/menus', [RoleController::class, 'menus']);
    // Route::match(array('GET'),'menus', [RoleController::class,'menus']);
    Route::match(array('GET'),'profile', [MerchantController::class,'myProfile']);
    Route::match(array('POST'),'profile', [MerchantController::class,'store']);
    Route::match(array('GET'),'pendidikan-terakhir/{id}', [ProfileMahasiswaController::class,'pendidikanTerakhir']);
    Route::match(array('GET'),'kuesioner-mahasiswa/{id}', [ProfileMahasiswaController::class,'kuesionerMahasiswa']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group(["prefix" => "/roles"], function ($router) {
    Route::group(["prefix" => "/role_permissions"], function ($router) {
        Route::get("/", [RolePermissionsController::class, 'index']);
        Route::post("/", [RolePermissionsController::class, 'store']);
    });

    Route::group(["prefix" => "/role_menus"], function ($router) {
        Route::get("/", [RoleMenusController::class, 'index']);
        Route::post("/", [RoleMenusController::class, 'store']);
    });

    Route::get("/", [RoleController::class, 'index']);
    Route::get("/{id}", [RoleController::class, 'findById']);
    Route::post("/", [RoleController::class, 'store']);
    Route::put("/{id}", [RoleController::class, 'store']);
    Route::put("/{id}/restore", [RoleController::class, 'restore']);
    Route::delete("/{id}", [RoleController::class, 'remove']);
});

Route::group(["prefix" => "/url"], function ($router) {
    Route::get("/", [UrlController::class, 'index']);
    Route::get("/{id}", [UrlController::class, 'findById']);
    Route::post("/", [UrlController::class, 'store']);
    Route::put("/{id}", [UrlController::class, 'store']);
    Route::put("/{id}/restore", [UrlController::class, 'restore']);
    Route::delete("/{id}", [UrlController::class, 'remove']);
    Route::post("/generate-permission/{id}", [UrlController::class, 'permission']);
});

Route::group(["prefix" => "/accounts"], function ($router) {
    Route::get("/", [AccountsController::class, 'index']);
    Route::get("/{id}", [AccountsController::class, 'findById']);
    Route::post("/", [AccountsController::class, 'store']);
    Route::put("/{id}", [AccountsController::class, 'store']);
    Route::put("/{id}/restore", [AccountsController::class, 'restore']);
    Route::delete("/{id}", [AccountsController::class, 'remove']);
});

Route::group(["prefix" => "/permissions"], function ($router) {
    Route::get("/", [PermissionsController::class, 'index']);
    Route::get("/{id}", [PermissionsController::class, 'findById']);
    Route::post("/", [PermissionsController::class, 'store']);
    Route::put("/{id}", [PermissionsController::class, 'store']);
    Route::put("/{id}/restore", [PermissionsController::class, 'restore']);
    Route::delete("/{id}", [PermissionsController::class, 'remove']);
});


Route::group(["prefix" => "/merchant"], function ($router) {
    Route::get("/", [MerchantController::class, 'index']);
    Route::get("/{id}", [MerchantController::class, 'findById']);
    Route::post("/", [MerchantController::class, 'store']);
    Route::put("/{id}", [MerchantController::class, 'store']);
    Route::put("/{id}/restore", [MerchantController::class, 'restore']);
    Route::delete("/{id}", [MerchantController::class, 'remove']);
});

Route::group(["prefix" => "/menu"], function ($router) {
    Route::get("/", [MerchantMenuController::class, 'index']);
    Route::get("/{id}", [MerchantMenuController::class, 'findById']);
    Route::post("/", [MerchantMenuController::class, 'store']);
    Route::put("/{id}", [MerchantMenuController::class, 'store']);
    Route::put("/{id}/restore", [MerchantMenuController::class, 'restore']);
    Route::delete("/{id}", [MerchantMenuController::class, 'remove']);
});

Route::group(["prefix" => "/order"], function ($router) {
    Route::get("/", [OrdersController::class, 'index']);
    Route::get("/{id}", [OrdersController::class, 'findById']);
    Route::post("/", [OrdersController::class, 'store']);
    Route::put("/{id}", [OrdersController::class, 'store']);
    Route::put("/{id}/restore", [OrdersController::class, 'restore']);
    Route::delete("/{id}", [OrdersController::class, 'remove']);
});
