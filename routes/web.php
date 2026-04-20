<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DtrScheduleController;
use App\Http\Controllers\PersonnelController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::view('login', 'auth.login')->name('login')->middleware('guest');
    Route::post('login', [AuthController::class, 'login'])->name('loginAttempt')->middleware('guest');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::get('password/{password}', function ($password) {
    return bcrypt($password);
});

Route::group(["prefix" => "personnels", "as" => "personnels.", "middleware" => "auth"], function () {
    Route::get("/", [PersonnelController::class, "index"])->name("index");
    Route::get("/edit/{id}", [PersonnelController::class, "edit"])->name("edit");
    Route::post("/update", [PersonnelController::class, "update"])->name("update");
    Route::get("/create", [PersonnelController::class, "create"])->name("create");
    Route::post("/store", [PersonnelController::class, "store"])->name("store");
});
Route::group(["prefix" => "dtr_schedules", "as" => "dtr_schedules.", "middleware" => "auth"], function () {
    Route::get("/", [DtrScheduleController::class, "index"])->name("index");
    Route::post("/update", [DtrScheduleController::class, "update"])->name("update");
    Route::post("/store", [DtrScheduleController::class, "store"])->name("store");
    Route::delete("/delete/{id}", [DtrScheduleController::class, "delete"])->name("delete");
});

