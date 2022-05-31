<?php

use App\Http\Controllers\API\OrphanageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DonationController;
use App\Http\Controllers\API\GetDonationController;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user/update', [UserController::class, 'updateProfile']);
    Route::post('user/photo', [UserController::class, 'updatePhoto']);
    Route::get('user/panti', [UserController::class, 'panti']);
    Route::get('user/panti/{id}', [UserController::class, 'orphanage']);

    Route::post('logout', [UserController::class, 'logout']);

    Route::get('donation', [DonationController::class, 'index']);
    Route::post('donation/store', [DonationController::class, 'store']);
    // Route::post('donation/store/{id}', [DonationController::class, 'update']);
    Route::post('donation/getdonation/{id}', [DonationController::class, 'edit']);
    Route::get('donation/getuser/{userId}', [DonationController::class, 'show']);

    Route::get('getdonation', [GetDonationController::class, 'all']);

    // Route::get('donation', [DonationController::class, 'all']);
    // Route::post('donation/{id}', [DonationController::class, 'update']);

    // Route::post('checkout', [TransactionController::class, 'checkout']);
});

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::post('donation/store/{id}', [DonationController::class, 'update']);


// Route::get('donation', [DonationController::class, 'index']);
// Route::post('orlogin', [OrphanageController::class, 'orlogin']);
// Route::post('orregister', [OrphanageController::class, 'orregister']);

// Route::get('item', [ItemController::class, 'all']);
