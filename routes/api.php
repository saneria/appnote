<?php

use App\Http\Controllers\NotesController;
use Illuminate\Http\Request;
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

Route::controller(NotesController::class)->group(function () {
    Route::get('/notes',             'index');
    Route::get('/notes/{id}',        'show');
    Route::post('/notes',            'store');
    Route::put('/notes/{id}',        'update');
    Route::delete('/notes/{id}',     'destroy');
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
