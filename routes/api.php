<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\InmobiliariaController;
use App\Http\Controllers\InmuebleController;
use App\Http\Controllers\RentaController;
use App\Http\Controllers\VentaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:api')->group(function () {
    Route::get('inmobiliarias', [InmobiliariaController::class, 'index']);
    Route::get('inmobiliarias/{id}', [InmobiliariaController::class, 'show']);
    Route::post('inmobiliarias', [InmobiliariaController::class, 'store']);
    Route::put('inmobiliarias/{id}', [InmobiliariaController::class, 'update']);
    Route::delete('inmobiliarias/{id}', [InmobiliariaController::class, 'destroy']);
});

Route::get('inmuebles', [InmuebleController::class, 'index']);
Route::get('inmuebles/{id}', [InmuebleController::class, 'show']);
Route::middleware('auth:api')->group(function () {
    Route::post('inmuebles', [InmuebleController::class, 'store']);
    Route::put('inmuebles/{id}', [InmuebleController::class, 'update']);
    Route::delete('inmuebles/{id}', [InmuebleController::class, 'destroy']);
});


Route::middleware('auth:api')->group(function () {
    Route::post('calificaciones', [CalificacionController::class, 'store']);
    Route::put('calificaciones/{id}', [CalificacionController::class, 'update']);
    Route::delete('calificaciones/{id}', [CalificacionController::class, 'destroy']);
});


Route::middleware('auth:api')->group(function () {
    Route::get('ventas', [VentaController::class, 'index']);
    Route::post('ventas', [VentaController::class, 'store']);
    Route::get('ventas/{id}', [VentaController::class, 'show']);
});


Route::middleware('auth:api')->group(function () {
    Route::get('rentas', [RentaController::class, 'index']);
    Route::post('rentas', [RentaController::class, 'store']);
    Route::get('rentas/{id}', [RentaController::class, 'show']);
});
