<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SignupUser;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Product\DesignController;
use App\Http\Controllers\Product\OrderController;
use App\Http\Controllers\Product\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/',[PageController::class,'home']);
Route::get('/about',[PageController::class,'about']); 
Route::get('/shop/show/{product}',[ShopController::class,'show'])->name('shop.show');
Route::get('/shop',[ShopController::class,'index']);
Route::get('/search-products', [ShopController::class, 'search']);

Route::middleware('auth')->group(function () {
    Route::post('/customize/add/{design}',[ShopController::class,'storeDesign'])->name('design.add');
    Route::post('/shop/add/{product}',[ShopController::class,'store'])->name('product.add');
    Route::delete('/logout',[LoginController::class,'destroy']);
    Route::get('/chat/users', [ChatController::class, 'users']);
    Route::get('/chat/messages/{id}', [ChatController::class, 'messages']);
    Route::post('/chat/send', [ChatController::class, 'send']);
});

Route::middleware('admin')->group(function () {
Route::get('/admin/home',[PageController::class,'create']);
Route::post('/new',[PageController::class,'store']);
Route::post('/new/about',[PageController::class,'storeAbout']);
Route::get('/admin/customize',[AdminController::class,'customize']);
Route::get('/admin',[AdminController::class,'index']);
Route::post('/admin',[AdminController::class,'store']);
Route::post('/admin/category',[AdminController::class,'createCategory']);
Route::post('/admin/material',[AdminController::class,'createMaterial']);
Route::put('/admin/products/{product}',[AdminController::class,'updateShop']);
Route::patch('/admin/products/{product}',[AdminController::class,'destroy']);
Route::patch('/admin/{design}/status',[AdminController::class,'update']);
Route::patch('/admin/reject/{design}',[AdminController::class,'reject']);
Route::patch('/orders/{order}/delivery', [OrderController::class, 'delivery']);
});


Route::middleware('guest')->group(function(){
Route::get('/signup',[SignupUser::class,'create']);
Route::post('/signup',[SignupUser::class,'store']);
Route::get('/login',[LoginController::class,'create'])->name('login');
Route::post('/login',[LoginController::class,'store']);    
    });
    
Route::middleware(['customer'])->group(function(){
Route::get('/customize',[DesignController::class,'index']);
Route::post('/customize',[DesignController::class,'store']);
Route::patch('/customize/{design}',[DesignController::class,'destroy']);
Route::put('/customize/update/{design}',[DesignController::class,'update']);
Route::get('/cart',[OrderController::class,'index']);
Route::patch('/order/confirm/{order}',[OrderController::class,'update']);
Route::patch('/cart/remove/{order}',[OrderController::class,'destroy']);
 });