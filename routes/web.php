<?php

use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/",[AuthController::class,"index"]);
Route::post("/",[AuthController::class,"store"])->name("login");
Route::get("/logout",[AuthController::class,"destroy"])->name("logout");

Route::prefix("account")->group(function () {
    Route::middleware("auth")->group(function () {
        Route::get("/dashboard",[DashboardController::class,"index"])->name("dashboard");
        Route::resource("arsip",ArsipController::class);
        Route::resource("profile",ProfileController::class);
        Route::resource("kategori",KategoriController::class);
        Route::resource("user",UserController::class);
        
    });
});

