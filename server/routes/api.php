<?php

use Illuminate\Support\Facades\Route;

// users
Route::apiResource('/v1/users', App\Http\Controllers\Api\UserController::class);
