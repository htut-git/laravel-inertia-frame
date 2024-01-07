<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('users-table',[UserController::class,'getDataTable'])->name('users-table');
    Route::resource('users', UserController::class)->names('users');

    Route::get('roles-table',[RolesController::class,'getDataTable'])->name('roles-table');
    Route::resource('roles', RolesController::class)->names('roles');
});
