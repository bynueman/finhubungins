<?php

use App\Http\Controllers\InvoicePdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Invoice PDF Routes
Route::get('invoice/{id}/pdf', [InvoicePdfController::class, 'download'])->name('invoice.pdf.download');
Route::get('invoice/{id}/preview', [InvoicePdfController::class, 'stream'])->name('invoice.pdf.preview');
Route::get('invoice/bulk-download/{ids}', 'App\Http\Controllers\InvoiceController@bulkDownload')
    ->name('invoice.bulk.download');

    