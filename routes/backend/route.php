<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RolesController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['role:Super Admin|admin','auth:web','verified'])->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class)->names('users');
    Route::post('users/update-password/{id}', [UserController::class,'updatePassword'])->name('users.updatePassword');
    Route::post('users/destroy-sessions/{id}', [UserController::class,'destroySession'])->name('users.destroySession');


    Route::get('roles-table',[RolesController::class,'getDataTable'])->name('roles-table');
    Route::resource('roles', RolesController::class)->names('roles');
});
