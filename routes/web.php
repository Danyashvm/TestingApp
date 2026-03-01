<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckController;

Route::get("/", [CheckController::class, "index"]);
Route::post("/check", [CheckController::class, "store"]);
Route::get("/history", [CheckController::class, "history"]);
