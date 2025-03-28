<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorsController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // Auth Routes (No Middleware)
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    // Protected Routes (Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('tickets', TicketController::class)->except(['update']);
        Route::put('tickets/{ticket}', [TicketController::class, 'replace']);
        Route::patch('tickets/{ticket}', [TicketController::class, 'update']);

        Route::apiResource('authors', AuthorsController::class);
        Route::apiResource('authors.tickets', AuthorTicketsController::class)->except(['update']);
        Route::put('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'replace']);
        Route::patch('authors/{author}/tickets/{ticket}', [AuthorTicketsController::class, 'update']);

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
