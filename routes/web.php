<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupUser;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Product\DesignController;
use App\Http\Controllers\Product\OrderController;
use App\Http\Controllers\Product\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PageController::class,'home']);
Route::get('/about',[PageController::class,'about']); 

Route::middleware('admin')->group(function () {
Route::get('/admin',[AdminController::class,'index']);
Route::post('/admin',[AdminController::class,'store']);
Route::post('/admin/category',[AdminController::class,'createCategory']);
Route::post('/admin/material',[AdminController::class,'createMaterial']);
Route::put('/admin/products/{product}',[AdminController::class,'updateShop']);
Route::delete('/admin/products/{product}',[AdminController::class,'destroy']);
Route::patch('/admin/{design}/status',[AdminController::class,'update']);
Route::get('/admin/custom/{design}',[AdminController::class,'show']);
});

Route::get('/shop/show/{product}',[ShopController::class,'show'])->name('shop.show');
Route::get('/shop',[ShopController::class,'index']);


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
Route::put('/customize/update/{design}',[DesignController::class,'update']);
Route::get('/cart',[OrderController::class,'index']);
Route::delete('/cart/remove/{order}',[OrderController::class,'destroy']);
Route::post('/shop/add/{product}',[ShopController::class,'store'])->name('product.add');
 });