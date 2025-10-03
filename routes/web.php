<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
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

// Admin authentication & dashboard routes
Route::prefix('admin')->name('admin.')->group(function () {
  Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
  });

  Route::middleware('admin.api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/me', [AuthController::class, 'currentUser'])->name('me');
    Route::get('/', function () {
      return view('admin.app');
    })->name('index');
    Route::get('/{view?}', function () {
      return view('admin.app');
    })->where('view', '.*');
  });
});

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
