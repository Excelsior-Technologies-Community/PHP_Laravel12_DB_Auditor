<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);

Route::get('/trash-products', [ProductController::class, 'trash'])
    ->name('products.trash');

Route::get('/restore-product/{id}', [ProductController::class, 'restore'])
    ->name('products.restore');

Route::get('/audit-logs', function () {

    $logs = DB::table('audit_logs')
        ->when(request('action'), function ($query) {
            $query->where('action', request('action'));
        })
        ->oldest()
        ->paginate(4);

    return view('audit.index', compact('logs'));
});