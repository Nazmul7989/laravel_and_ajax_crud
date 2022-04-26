<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;





Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth',],function (){

    Route::get('/product',[ProductController::class,'index'])->name('product.index');
    Route::get('/product/get',[ProductController::class,'get'])->name('product.get');
    Route::get('/product/show/{id}',[ProductController::class,'show'])->name('product.show');
    Route::post('/product/store',[ProductController::class,'store'])->name('product.store');
    Route::post('/product/update/{id}',[ProductController::class,'update'])->name('product.update');
    Route::get('/product/delete/{id}',[ProductController::class,'delete'])->name('product.delete');

});
