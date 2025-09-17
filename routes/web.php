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

// Admin authentication routes (if using Laravel Breeze/Fortify)
// These would be added when implementing authentication
// Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
// Route::post('/admin/login', [LoginController::class, 'login']);
// Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

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
