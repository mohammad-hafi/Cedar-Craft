<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupUser;
use App\Http\Controllers\Product\DesignController;
use App\Http\Controllers\Product\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/home');
});
Route::get('/shop',[ShopController::class,'index']);
Route::get('/shop/show/{product}',[ShopController::class,'show'])->name('shop.show');
Route::post('/shop/add/{product}',[ShopController::class,'store'])->name('product.add');

Route::get('/admin',[AdminController::class,'index']);
Route::post('/admin',[AdminController::class,'store']);
Route::patch('/admin/{design}/status',[AdminController::class,'update']);

Route::middleware('guest')->group(function(){
Route::get('/signup',[SignupUser::class,'create']);
Route::post('/signup',[SignupUser::class,'store']);
Route::get('/login',[LoginController::class,'create'])->name('login');
Route::post('/login',[LoginController::class,'store']);
});

Route::middleware('auth')->group(function(){
Route::delete('/logout',[LoginController::class,'destroy']);
Route::get('/customize',[DesignController::class,'index']);
Route::post('/customize',[DesignController::class,'store']);
Route::delete('/customize/{design}',[DesignController::class,'destroy']);
 });