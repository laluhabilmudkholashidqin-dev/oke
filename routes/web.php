<?php

use App\Http\Controllers\ClockController;
use App\Http\Controllers\TimezoneController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClockController::class, 'index'])->name('clock.index');
Route::get('/api/time', [ClockController::class, 'getTime'])->name('clock.time');
Route::post('/api/time', [ClockController::class, 'getTimeInTimezone'])->name('clock.timezone');
Route::get('/api/timezones', [TimezoneController::class, 'list'])->name('timezone.list');
Route::post('/api/timezone/offset', [TimezoneController::class, 'getOffset'])->name('timezone.offset');
