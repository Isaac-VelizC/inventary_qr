<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',  [AreaController::class, 'index']);
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
Route::delete('/item/{id}', [ItemController::class, 'destroy']);
Route::get('/item/{id}/show',  [ItemController::class, 'show']);

Route::post('area/{id}/qr', [QrController::class, 'show']);
Route::post('area/{id}/qr/create', [QrController::class, 'create']);
Route::post('scan', [QrController::class, 'verify']);
Route::get('scan', [QrController::class, 'scan'])->name('scan');
Route::get('/qrcode/{id}', [QrController::class, 'show'])->name('qrcode.show');
Route::get('/vistaQR/{id}', [ItemController::class, 'vistaQR']);

