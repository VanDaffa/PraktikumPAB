<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controller\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/users', \App\Http\Controllers\UserController::class);
