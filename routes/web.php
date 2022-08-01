<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\LoginAuth;
use App\Http\Middleware\AdminAuth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\Admin\UserController;

Route::controller(LoginController::class)->group(function () {
    Route::get('/login','index')->name('login');
    Route::post('/login/login','login')->name('login.login');
    Route::post('/login/admin','loginAdmin')->name('login.admin');
    Route::get('/logout','logout')->name('logout');
});

Route::middleware(LoginAuth::class)->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::post('/point/create', [PointController::class,'create'])->name('point.create');
});

Route::middleware(AdminAuth::class)->group(function () {
    Route::get('/admin',[AdminController::class,'waiting'])->name('admin');
    Route::match(['GET','POST'],'/admin/waiting', [AdminController::class,'waiting'])->name('waiting');
    Route::match(['GET','POST'],'/admin/answered', [AdminController::class,'answered'])->name('answered');
    Route::match(['POST'],'/admin/pointStatusUpdate/{id}',[AdminController::class,'pointStatusUpdate'])->name('pointStatusUpdate');
    Route::get('/admin/users',[UserController::class,'index'])->name('users');
    Route::post('/admin/users/{id}',[UserController::class,'update'])->name('user.update');
});

