<?php

use Illuminate\Support\Facades\Route;
use Laravel\Telescope\Http\Controllers\HomeController;

Route::middleware(['admin', 'auth'])->get('admin', [HomeController::class, 'index'])->name('admin.index');

require __DIR__ . '/auth.php';
