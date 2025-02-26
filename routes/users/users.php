<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// RUTA PARA ENRUTAR /user/
Route::get('/login', [UserController::class, 'showLogin'])->name('user.showLogin'); // IMPORTANTE PARA LARAVEL
Route::get('/register', [UserController::class, 'registerView'])->name('user.showRegister');

Route::get('/login', [UserController::class, 'showLogin'])->name('login'); // la uso otra vez porque laravel dice que no está definida (?)


Route::post('/login', [UserController::class, 'doLogin'])->name('user.doLogin');
Route::post('/register', [UserController::class, 'doRegister'])->name('user.doRegister');

Route::middleware(['auth'])->group(function(){

    Route::get('/index/{id}', [UserController::class, 'showIndex'])->name('user.showIndex');
    Route::get('/logout', [UserController::class, 'doLogout'])->name('user.doLogout');
    Route::delete('/delete/{id}', [UserController::class, 'unsubscribe'])->name('user.delete');

    // hacer ruta para los likes


});