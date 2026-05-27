<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuditController;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);

Route::get('/trash-products', [ProductController::class, 'trash'])
    ->name('products.trash');

Route::get('/restore-product/{id}', [ProductController::class, 'restore'])
    ->name('products.restore');

Route::get('/audit-logs',[AuditController::class, 'index'])
    ->name('audit.index');

Route::get('/audit-logs/export',[AuditController::class, 'export'])
    ->name('audit.export');