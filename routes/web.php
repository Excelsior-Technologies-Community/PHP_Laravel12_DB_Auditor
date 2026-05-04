<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);



Route::get('/audit-logs', function () {
    $logs = DB::table('audit_logs')->latest()->get();
    return view('audit.index', compact('logs'));
});