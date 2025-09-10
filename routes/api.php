<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiteController;

Route::get('/home', [SiteController::class, 'home']);
Route::get('/about', [SiteController::class, 'about']);
Route::get('/news', [SiteController::class, 'news']);
Route::get('/jobs', [SiteController::class, 'jobs']);
Route::post('/contact', [SiteController::class, 'contact']);
