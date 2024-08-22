<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ActivateController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\DeactivateController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class);
Route::apiResource('/accounts', AccountController::class);
Route::get('/accounts/{account}/activate', [ActivateController::class, 'store']);
Route::get('/accounts/{account}/deactivate', [DeactivateController::class, 'store']);
Route::get('/accounts/{account}/balance', [BalanceController::class, 'store']);
Route::get('/accounts/{account}/deposit', [DepositController::class, 'store']);
Route::get('/accounts/{account}/withdraw', [WithdrawController::class, 'store']);
Route::get('/accounts/{account}/transfer', [TransferController::class, 'store']);

Route::apiResource('/transactions', TransactionController::class);
