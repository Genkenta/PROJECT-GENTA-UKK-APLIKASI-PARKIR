<?php

use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\StrukController;
use Illuminate\Support\Facades\Route;



Route::get('/login', [CustomLoginController::class, 'index'])->name('login');
Route::post('/login', [CustomLoginController::class, 'authenticate'])->name('authenticate');

Route::get('/struk/{id}', [StrukController::class, 'print'])
    ->name('struk.print');


// require __DIR__.'/auth.php';
