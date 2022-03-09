<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout-admin');

    Route::get('/', [DashboardController::class, 'home'])->name('home');


    Route::get('view-post', [PostController::class, 'table'])->name('view-post');
    Route::get('post-list', [PostController::class, 'list'])->name('post-list');
    Route::get('view-student', [StudentController::class, 'table'])->name('view-student');
    Route::get('student-list', [StudentController::class, 'list'])->name('student-list');
});
