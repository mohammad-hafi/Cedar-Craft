<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/home');
});

Route::middleware('guest')->group(function(){
Route::get('/signup',[SignupUser::class,'create']);
Route::post('/signup',[SignupUser::class,'store']);
Route::get('/login',[LoginController::class,'create'])->name('login');
Route::post('/login',[LoginController::class,'store']);
});

Route::middleware('auth')->group(function(){
Route::delete('/logout',[LoginController::class,'destroy']);
 });