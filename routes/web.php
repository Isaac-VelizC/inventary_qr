<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->namespace('Admin')->prefix('admin')->group(function () {
    Route::get('/area/create', [AreaController::class, 'create']); 
    Route::post('/area', [AreaController::class, 'store']);
    Route::get('/area/{id}/edit', [AreaController::class, 'edit']);
    Route::post('/area/{id}/edit', [AreaController::class, 'update']);
    Route::delete('/area/{id}', [AreaController::class, 'destroy']);
    Route::get('/area/{id}/show',  [AreaController::class, 'show']);
    //Route::get('/item',  [ItemController::class, 'index']);
    Route::get('/item/create/{id}', [ItemController::class, 'create']);
    Route::post('/item', [ItemController::class, 'store']);
    Route::get('/item/{id}/edit', [ItemController::class, 'edit']);
    Route::post('/item/{id}/edit', [ItemController::class, 'update']);
    Route::post('/item/{id}/delete', [ItemController::class, 'destroy']);
    Route::get('/item/{id}/show',  [ItemController::class, 'show']);
    Route::get('/item/{id}/history',  [ItemController::class, 'history']);
    Route::post('area/{id}/qr', [QrController::class, 'show']);
    Route::post('area/{id}/qr/create', [QrController::class, 'create']);
    Route::get('/qrcode/{id}', [QrController::class, 'show'])->name('qrcode.show');
    Route::post('/printQR', [ItemController::class, 'printQR']);
    Route::get('/printPdf/{id}', [ItemController::class, 'printPDf']);
    Route::get('/generar-pdf', [AreaController::class, 'generarPDF']);
    ///Usuarios
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/users/create', [UsersController::class, 'create']);
    Route::post('/users', [UsersController::class, 'store']);
    Route::get('/users/{id}/edit', [UsersController::class, 'edit']);
    Route::post('/users/{id}/edit', [UsersController::class, 'update']);
    Route::delete('/users/{id}/delete', [UsersController::class, 'destroy']);
    Route::get('/users/{id}/show',  [UsersController::class, 'show']);
    ///Sin permiso
    Route::get('/error', [HomeController::class, 'sinPermiso']);
});

Route::get('/vistaQR/{id}', [ItemController::class, 'vistaQR']);

