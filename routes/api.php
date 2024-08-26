<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ActivateAccountController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\DeactivateAccountController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class);
Route::apiResource('/accounts', AccountController::class);
Route::patch('/accounts/{account}/activate', [ActivateAccountController::class, 'update']);
Route::delete('/accounts/{account}/deactivate', [DeactivateAccountController::class, 'destroy']);
Route::get('/accounts/{account}/balance', [BalanceController::class, 'show']);
Route::post('/accounts/{account}/deposit', [DepositController::class, 'store']);
Route::post('/accounts/{account}/withdraw', [WithdrawController::class, 'store']);
Route::get('/accounts/{account}/transfer', [TransferController::class, 'store']);

Route::apiResource('/transactions', TransactionController::class);
