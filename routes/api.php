<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\VoucherController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::resource('voucher', VoucherController::class);
Route::middleware('custom.sanctum.auth')->group(function () {
});

Route::post('login', [LoginController::class, 'login']);
