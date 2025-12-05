<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Home';
})->name('home');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show']);
    Route::resource('tournaments', \App\Http\Controllers\TournamentController::class);
    Route::resource('tournament-officials', \App\Http\Controllers\TournamentOfficialController::class)->except(['show']);
    Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::resource('hotels', \App\Http\Controllers\HotelController::class);
    Route::resource('schedules', \App\Http\Controllers\ScheduleController::class);
});

require __DIR__ . '/auth.php';
require __DIR__ . '/settings.php';
