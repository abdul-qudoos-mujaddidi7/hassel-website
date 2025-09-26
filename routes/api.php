<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import all API controllers
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\SuccessStoryController;
use App\Http\Controllers\Api\RfpRfqController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TrainingProgramController;
use App\Http\Controllers\Api\AgriTechToolController;
use App\Http\Controllers\Api\MarketAccessProgramController;
use App\Http\Controllers\Api\EnvironmentalProjectController;
use App\Http\Controllers\Api\CommunityProgramController;
use App\Http\Controllers\Api\ProgramRegistrationController;

// Import admin controllers
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\AdminNewsController;
use App\Http\Controllers\Api\Admin\AdminPublicationController;
use App\Http\Controllers\Api\Admin\AdminSuccessStoryController;
use App\Http\Controllers\Api\Admin\AdminRfpRfqController;
use App\Http\Controllers\Api\Admin\AdminGalleryController;
use App\Http\Controllers\Api\Admin\AdminJobController;
use App\Http\Controllers\Api\Admin\AdminContactController;
use App\Http\Controllers\Api\Admin\AdminStatsController;
use App\Http\Controllers\Api\Admin\AdminTranslationController;
use App\Http\Controllers\Api\Admin\AdminTrainingProgramController;
use App\Http\Controllers\Api\Admin\AdminAgriTechToolController;
use App\Http\Controllers\Api\Admin\AdminMarketAccessProgramController;
use App\Http\Controllers\Api\Admin\AdminEnvironmentalProjectController;
use App\Http\Controllers\Api\Admin\AdminCommunityProgramController;
use App\Http\Controllers\Api\Admin\AdminProgramRegistrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
| All routes support ?lang=en/pashto/farsi parameter for multi-language
*/

// =============================================================================
// CORE CONTENT ROUTES
// =============================================================================

// Home & General
Route::get('/', [HomeController::class, 'index'])->name('api.home');
Route::get('/about', [HomeController::class, 'about'])->name('api.about');
Route::get('/stats', [HomeController::class, 'stats'])->name('api.stats');

// News
Route::prefix('news')->name('api.news.')->group(function () {
  Route::get('/', [NewsController::class, 'index'])->name('index');
  Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
});

// Publications
Route::prefix('publications')->name('api.publications.')->group(function () {
  Route::get('/', [PublicationController::class, 'index'])->name('index');
  Route::get('/types', [PublicationController::class, 'types'])->name('types');
});

// Success Stories
Route::prefix('success-stories')->name('api.success-stories.')->group(function () {
  Route::get('/', [SuccessStoryController::class, 'index'])->name('index');
  Route::get('/{slug}', [SuccessStoryController::class, 'show'])->name('show');
});

// RFPs/RFQs
Route::prefix('rfps-rfqs')->name('api.rfps-rfqs.')->group(function () {
  Route::get('/', [RfpRfqController::class, 'index'])->name('index');
  Route::get('/{slug}', [RfpRfqController::class, 'show'])->name('show');
});

// Galleries
Route::prefix('galleries')->name('api.galleries.')->group(function () {
  Route::get('/', [GalleryController::class, 'index'])->name('index');
  Route::get('/{slug}', [GalleryController::class, 'show'])->name('show');
});

// Jobs
Route::prefix('jobs')->name('api.jobs.')->group(function () {
  Route::get('/', [JobController::class, 'index'])->name('index');
  Route::get('/{slug}', [JobController::class, 'show'])->name('show');
  Route::get('/locations', [JobController::class, 'locations'])->name('locations');
});

// Contact
Route::prefix('contact')->name('api.contact.')->group(function () {
  Route::post('/', [ContactController::class, 'store'])->name('store');
  Route::get('/info', [ContactController::class, 'info'])->name('info');
});

// =============================================================================
// BUSINESS PILLAR ROUTES
// =============================================================================

// Training Programs
Route::prefix('training-programs')->name('api.training-programs.')->group(function () {
  Route::get('/', [TrainingProgramController::class, 'index'])->name('index');
  Route::get('/types', [TrainingProgramController::class, 'types'])->name('types');
  Route::get('/{slug}', [TrainingProgramController::class, 'show'])->name('show');
});

// Agri-Tech Tools
Route::prefix('agri-tech-tools')->name('api.agri-tech-tools.')->group(function () {
  Route::get('/', [AgriTechToolController::class, 'index'])->name('index');
  Route::get('/{slug}', [AgriTechToolController::class, 'show'])->name('show');
  Route::get('/types', [AgriTechToolController::class, 'types'])->name('types');
  Route::get('/platforms', [AgriTechToolController::class, 'platforms'])->name('platforms');
});

// Market Access Programs
Route::prefix('market-access-programs')->name('api.market-access-programs.')->group(function () {
  Route::get('/', [MarketAccessProgramController::class, 'index'])->name('index');
  Route::get('/{slug}', [MarketAccessProgramController::class, 'show'])->name('show');
  Route::get('/types', [MarketAccessProgramController::class, 'types'])->name('types');
});

// Environmental Projects
Route::prefix('environmental-projects')->name('api.environmental-projects.')->group(function () {
  Route::get('/', [EnvironmentalProjectController::class, 'index'])->name('index');
  Route::get('/{slug}', [EnvironmentalProjectController::class, 'show'])->name('show');
  Route::get('/types', [EnvironmentalProjectController::class, 'types'])->name('types');
});

// Community Programs
Route::prefix('community-programs')->name('api.community-programs.')->group(function () {
  Route::get('/', [CommunityProgramController::class, 'index'])->name('index');
  Route::get('/{slug}', [CommunityProgramController::class, 'show'])->name('show');
  Route::get('/types', [CommunityProgramController::class, 'types'])->name('types');
  Route::get('/target-groups', [CommunityProgramController::class, 'targetGroups'])->name('target-groups');
});

// Program Registration
Route::prefix('program-registration')->name('api.program-registration.')->group(function () {
  Route::post('/', [ProgramRegistrationController::class, 'store'])->name('store');
  Route::get('/{registration}/status', [ProgramRegistrationController::class, 'status'])->name('status');
  Route::get('/user-registrations', [ProgramRegistrationController::class, 'userRegistrations'])->name('user-registrations');
});

// =============================================================================
// ADMIN API ROUTES (Protected by auth middleware)
// =============================================================================

Route::prefix('admin')->name('api.admin.')->middleware(['admin'])->group(function () {

  // Dashboard
  Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
  Route::get('/health', [AdminController::class, 'health'])->name('health');

  // Core Content Admin Routes
  Route::apiResource('news', AdminNewsController::class);
  Route::post('news/bulk-status', [AdminNewsController::class, 'bulkUpdateStatus'])->name('news.bulk-status');
  Route::get('news-stats', [AdminNewsController::class, 'stats'])->name('news.stats');

  Route::apiResource('publications', AdminPublicationController::class);
  Route::get('publications-stats', [AdminPublicationController::class, 'stats'])->name('publications.stats');

  Route::apiResource('success-stories', AdminSuccessStoryController::class);
  Route::apiResource('rfps-rfqs', AdminRfpRfqController::class);

  Route::apiResource('galleries', AdminGalleryController::class);
  Route::post('galleries/{gallery}/images', [AdminGalleryController::class, 'addImages'])->name('galleries.add-images');
  Route::delete('galleries/{gallery}/images/{image}', [AdminGalleryController::class, 'removeImage'])->name('galleries.remove-image');

  Route::apiResource('jobs', AdminJobController::class);

  // Contact Management
  Route::prefix('contacts')->name('contacts.')->group(function () {
    Route::get('/', [AdminContactController::class, 'index'])->name('index');
    Route::get('/{contact}', [AdminContactController::class, 'show'])->name('show');
    Route::delete('/{contact}', [AdminContactController::class, 'destroy'])->name('destroy');
    Route::post('/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('/export', [AdminContactController::class, 'export'])->name('export');
    Route::get('/stats', [AdminContactController::class, 'stats'])->name('stats');
  });

  // Statistics Management
  Route::apiResource('stats', AdminStatsController::class);
  Route::get('stats-summary', [AdminStatsController::class, 'summary'])->name('stats.summary');

  // Translation Management
  Route::prefix('translations')->name('translations.')->group(function () {
    Route::get('/', [AdminTranslationController::class, 'index'])->name('index');
    Route::post('/', [AdminTranslationController::class, 'store'])->name('store');
    Route::get('/{translation}', [AdminTranslationController::class, 'show'])->name('show');
    Route::put('/{translation}', [AdminTranslationController::class, 'update'])->name('update');
    Route::delete('/{translation}', [AdminTranslationController::class, 'destroy'])->name('destroy');
    Route::get('/for-model', [AdminTranslationController::class, 'forModel'])->name('for-model');
    Route::post('/bulk', [AdminTranslationController::class, 'bulkStore'])->name('bulk');
    Route::get('/stats', [AdminTranslationController::class, 'stats'])->name('stats');
  });

  // Business Pillar Admin Routes
  Route::apiResource('training-programs', AdminTrainingProgramController::class);
  Route::get('training-programs/{trainingProgram}/registrations', [AdminTrainingProgramController::class, 'registrations'])->name('training-programs.registrations');
  Route::get('training-programs-stats', [AdminTrainingProgramController::class, 'stats'])->name('training-programs.stats');

  Route::apiResource('agri-tech-tools', AdminAgriTechToolController::class);
  Route::apiResource('market-access-programs', AdminMarketAccessProgramController::class);
  Route::apiResource('environmental-projects', AdminEnvironmentalProjectController::class);
  Route::apiResource('community-programs', AdminCommunityProgramController::class);

  // Program Registration Management
  Route::prefix('program-registrations')->name('program-registrations.')->group(function () {
    Route::get('/', [AdminProgramRegistrationController::class, 'index'])->name('index');
    Route::get('/{programRegistration}', [AdminProgramRegistrationController::class, 'show'])->name('show');
    Route::put('/{programRegistration}/status', [AdminProgramRegistrationController::class, 'updateStatus'])->name('update-status');
    Route::delete('/{programRegistration}', [AdminProgramRegistrationController::class, 'destroy'])->name('destroy');
    Route::post('/bulk-status', [AdminProgramRegistrationController::class, 'bulkUpdateStatus'])->name('bulk-status');
    Route::get('/export', [AdminProgramRegistrationController::class, 'export'])->name('export');
    Route::get('/stats', [AdminProgramRegistrationController::class, 'stats'])->name('stats');
  });
});
