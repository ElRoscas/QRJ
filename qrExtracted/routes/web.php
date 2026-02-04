<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ImageProcessingController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

// Pàgina d'inici
Route::get('/', function () {
    return view('home');
});

// Rutes per QR Codes
Route::prefix('qr')->group(function () {
    Route::get('/create', [QrCodeController::class, 'create'])->name('qr.create');
    Route::post('/create', [QrCodeController::class, 'store'])->name('qr.store');
    Route::get('/read', [QrCodeController::class, 'read'])->name('qr.read');
    Route::post('/decode', [QrCodeController::class, 'decode'])->name('qr.decode');
});

// Rutes per Factures
Route::prefix('invoices')->group(function () {
    Route::get('/', [App\Http\Controllers\InvoicesController::class, 'index'])->name('invoices.index');
    Route::get('/create', [App\Http\Controllers\InvoicesController::class, 'create'])->name('invoices.create');
    Route::post('/store', [App\Http\Controllers\InvoicesController::class, 'store'])->name('invoices.store');
});

// Rutes originals (compatibilitat)
Route::get('/get-invoice', InvoiceController::class)->name('get-invoice');
Route::get('/process-qr-code', ImageProcessingController::class);
