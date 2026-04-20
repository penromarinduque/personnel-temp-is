<?php

use App\Http\Controllers\DtrScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(["prefix" => "dtr-schedules", "as" => "dtr-schedules."], function () {
    Route::get("show/{id}", [DtrScheduleController::class, "apiGetSchedule"])->name("apiGetSchedule");
});