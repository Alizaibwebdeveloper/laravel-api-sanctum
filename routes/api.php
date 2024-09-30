<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Models\User; // Fixed case sensitivity for the User model

// Open Routes
Route::post('register', [ApiController::class, 'register']);
Route::post('login', [ApiController::class, 'login']);

// Protected Routes
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('profile', [ApiController::class, 'profile']);
    Route::post('logout', [ApiController::class, 'logout']); // Changed to POST for logout
});
