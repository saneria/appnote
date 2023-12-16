<?php

use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/login', [AuthController::class, 'login'])->name('user.login');
Route::post('/user',  [UserController::class, 'store'])->name('user.store');

Route::controller(NotesController::class)->group(function () {
    Route::get('/notes',             'index');
    Route::get('/notes/{id}',        'show');
    Route::post('/notes',            'store');
    Route::put('/notes/edit/{id}',   'update');
    Route::delete('/notes/{id}',     'destroy');
    Route::put('/notes/{id}',        'restore');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user',                 'index');
    Route::get('/user/{id}',            'show');
    Route::put('/user/{id}',            'update')->name('user.update');
    Route::put('/user/email/{id}',      'email')->name('user.email');
    Route::put('/user/password/{id}',   'password')->name('us er.password');
    Route::delete('/user/{id}',         'destroy'); 
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout',[ AuthController::class, 'logout']);

});
