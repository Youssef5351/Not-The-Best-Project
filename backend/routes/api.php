<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;

Route::post('/login' , [AuthController::class , 'login'])->name("login");
Route::post('/signup', [AuthController::class, 'signup'])->name('signup');

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['message' => 'CSRF cookie set']);
})->middleware('web');

