<?php

use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\EnrollController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('classes')->controller(ClassController::class)->name('classes.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{classId}', 'show')->name('show');
    Route::post('/', 'store')->name('store');
    Route::put('/{classId}', 'update')->name('update');
    Route::delete('/{classId}', 'destroy')->name('destroy');
});

Route::prefix('user')->controller(UserController::class)->name('user.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{userId}', 'show')->name('show');
    Route::post('/', 'store')->name('store');
    Route::put('/{userId}', 'update')->name('update');
    Route::delete('/{userId}', 'destroy')->name('destroy');
});

Route::prefix('enroll')->controller(EnrollController::class)->name('enroll.')->group(function () {
    Route::post('/', 'enrollUser')->name('user');
    Route::put('/{enrollmentId}', 'updateEnrollment')->name('update');
    Route::delete('/{classId}/{userId}', 'revokeEnrollment')->name('revoke');
});
