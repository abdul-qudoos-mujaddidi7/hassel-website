<?php

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

/*
|--------------------------------------------------------------------------
| SPA Routes - Vue.js Frontend
|--------------------------------------------------------------------------
| All routes are handled by Vue Router for the Single Page Application
*/

// Health check route (useful for deployment)
Route::get('/health', function () {
  return response()->json([
    'status' => 'healthy',
    'timestamp' => now()->toISOString(),
    'version' => config('app.version', '1.0.0'),
  ]);
})->name('health');


/*
|--------------------------------------------------------------------------
| Admin Panel Routes
|--------------------------------------------------------------------------
| Admin panel entry points - all admin routes serve the admin.blade.php
*/

Route::get('/admin-zaki/{any?}', function () {
  return view('admin');
})->where('any', '.*')->name('admin');

/*
|--------------------------------------------------------------------------
| SPA Catch-All Route
|--------------------------------------------------------------------------
| This route catches all requests and serves the Vue.js SPA.
| Vue Router will handle client-side routing.
*/

Route::get('/{any}', function () {
  return view('spa');
})->where('any', '.*')->name('spa');
