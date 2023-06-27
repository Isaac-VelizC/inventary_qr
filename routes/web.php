<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

//Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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
});

Route::get('/vistaQR/{id}', [ItemController::class, 'vistaQR']);
