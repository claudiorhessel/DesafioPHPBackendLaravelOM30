<?php

use App\Http\Controllers\Api\AddressApiController;
use App\Http\Controllers\Api\AddressTypeApiController;
use App\Http\Controllers\Api\FileApiController;
use App\Http\Controllers\Api\FileTypeApiController;
use App\Http\Controllers\Api\PatientApiController;
use App\Http\Controllers\AuthController;
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

Route::group(['prefix' => 'v1'], function() {
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::group(['prefix' => 'user'], function() {
            Route::get('/', function (Request $request) {
                return $request->user();
            });
        });

        Route::group(['prefix' => 'patient'], function() {
            Route::get('/', [PatientApiController::class, 'index']);
            Route::get('/{id}', [PatientApiController::class, 'show']);
            Route::post('/', [PatientApiController::class, 'store']);
            Route::put('/{id}', [PatientApiController::class, 'login']);
            Route::delete('/{id}', [PatientApiController::class, 'destroy']);
        });

        Route::group(['prefix' => 'address_type'], function() {
            Route::get('/', [AddressTypeApiController::class, 'index']);
            Route::get('/{id}', [AddressTypeApiController::class, 'show']);
            Route::post('/', [AddressTypeApiController::class, 'store']);
            Route::put('/{id}', [AddressTypeApiController::class, 'update']);
            Route::delete('/{id}', [AddressTypeApiController::class, 'destroy']);
        });

        Route::group(['prefix' => 'address'], function() {
            Route::get('/', [AddressApiController::class, 'index']);
            Route::get('/{id}', [AddressApiController::class, 'show']);
            Route::post('/', [AddressApiController::class, 'store']);
            Route::put('/{id}', [AddressApiController::class, 'update']);
            Route::delete('/{id}', [AddressApiController::class, 'destroy']);
        });

        Route::group(['prefix' => 'file_type'], function() {
            Route::get('/', [FileTypeApiController::class, 'index']);
            Route::get('/{id}', [FileTypeApiController::class, 'show']);
            Route::post('/', [FileTypeApiController::class, 'store']);
            Route::put('/{id}', [FileTypeApiController::class, 'update']);
            Route::delete('/{id}', [FileTypeApiController::class, 'destroy']);
        });

        Route::group(['prefix' => 'file'], function() {
            Route::get('/', [FileApiController::class, 'index']);
            Route::get('/{id}', [FileApiController::class, 'show']);
            Route::post('/', [FileApiController::class, 'store']);
            Route::put('/{id}', [FileApiController::class, 'update']);
            Route::delete('/{id}', [FileApiController::class, 'destroy']);
        });
    });

    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'createUser']);
        Route::get('login', [AuthController::class, 'loginUser']);
    });
});

Route::get('unauthorized', function () {
    return response()->json(['error' => 'Unauthorized.'], 401);
})->name('unauthorized');

Route::any('{segment}', function () {
    return response()->json(['error' => 'Bad request.'], 400);
})->where('segment', '.*');
