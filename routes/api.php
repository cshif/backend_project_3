<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class);
Route::apiResource('/accounts', AccountController::class);
Route::apiResource('/transactions', TransactionController::class);
