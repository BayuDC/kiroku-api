<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Serve Vue app for all routes except API routes
Route::get('/{any}', function () {
    return response()->file(public_path('index.html'));
})->where('any', '^(?!api).*$');

// Handle root route specifically for Vue app
Route::get('/', function () {
    return response()->file(public_path('index.html'));
});
