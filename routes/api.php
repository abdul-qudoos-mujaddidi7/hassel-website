<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import all API controllers
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\SuccessStoryController;
use App\Http\Controllers\Api\JobAnnouncementController;
use App\Http\Controllers\Api\RfpRfqController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TrainingProgramController;
use App\Http\Controllers\Api\AgriTechToolController;
use App\Http\Controllers\Api\MarketAccessProgramController;
use App\Http\Controllers\Api\EnvironmentalProjectController;
use App\Http\Controllers\Api\CommunityProgramController;
use App\Http\Controllers\Api\SmartFarmingProgramController;
use App\Http\Controllers\Api\SeedSupplyProgramController;
use App\Http\Controllers\Api\ProgramRegistrationController;
use App\Http\Controllers\AuthController;

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

// Success Stories
Route::prefix('success-stories')->name('api.success_stories.')->group(function () {
  Route::get('/', [SuccessStoryController::class, 'index'])->name('index');
  Route::get('/{slug}', [SuccessStoryController::class, 'show'])->name('show');
});

// Job Announcements
Route::prefix('job-announcements')->name('api.job_announcements.')->group(function () {
  Route::get('/', [JobAnnouncementController::class, 'index'])->name('index');
  Route::get('/{slug}', [JobAnnouncementController::class, 'show'])->name('show');
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

// Translations
Route::get('/translations/{language}', [App\Http\Controllers\Api\TranslationController::class, 'getTranslations'])->name('translations.get');
Route::post('/translations', [App\Http\Controllers\Api\TranslationController::class, 'setTranslation'])->name('translations.set');

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
  Route::get('/types', [MarketAccessProgramController::class, 'types'])->name('types');
  Route::get('/{slug}', [MarketAccessProgramController::class, 'show'])->name('show');
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

// Smart & Sustainable Farming Programs
Route::prefix('smart-farming-programs')->name('api.smart-farming-programs.')->group(function () {
  Route::get('/', [SmartFarmingProgramController::class, 'index'])->name('index');
  Route::get('/{slug}', [SmartFarmingProgramController::class, 'show'])->name('show');
  Route::get('/types', [SmartFarmingProgramController::class, 'types'])->name('types');
  Route::get('/crops', [SmartFarmingProgramController::class, 'crops'])->name('crops');
});

// Seed & Input Supply Programs
Route::prefix('seed-supply-programs')->name('api.seed-supply-programs.')->group(function () {
  Route::get('/', [SeedSupplyProgramController::class, 'index'])->name('index');
  Route::get('/{slug}', [SeedSupplyProgramController::class, 'show'])->name('show');
  Route::get('/types', [SeedSupplyProgramController::class, 'types'])->name('types');
  Route::get('/crops', [SeedSupplyProgramController::class, 'crops'])->name('crops');
  Route::get('/availability', [SeedSupplyProgramController::class, 'availability'])->name('availability');
});

// Program Registration
Route::prefix('program-registration')->name('api.program-registration.')->group(function () {
  Route::post('/', [ProgramRegistrationController::class, 'store'])->name('store');
  Route::get('/{registration}/status', [ProgramRegistrationController::class, 'status'])->name('status');
  Route::get('/user-registrations', [ProgramRegistrationController::class, 'userRegistrations'])->name('user-registrations');
});

/*
|--------------------------------------------------------------------------
| Admin API Routes
|--------------------------------------------------------------------------
| Protected admin routes for content management
*/
// Admin Authentication Routes (public)
Route::prefix('admin')->name('api.admin.')->group(function () {
  Route::post('login', [App\Http\Controllers\Api\Admin\AuthController::class, 'login'])->name('login');
  Route::post('logout', [App\Http\Controllers\Api\Admin\AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
});

// Protected Admin Routes
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->name('api.admin.')->group(function () {
  // Dashboard
  Route::get('/dashboard/stats', [App\Http\Controllers\Api\Admin\DashboardController::class, 'stats'])->name('dashboard.stats');

  // Content Management
  Route::post('news/{news}', [App\Http\Controllers\Api\Admin\NewsController::class, 'updateNews'])->name('news.update');
  Route::apiResource('news', App\Http\Controllers\Api\Admin\NewsController::class)->except('update');
  Route::post('success-stories/{successStory}', [App\Http\Controllers\Api\Admin\SuccessStoriesController::class, 'update'])->name('success-stories.update');
  Route::apiResource('success-stories', App\Http\Controllers\Api\Admin\SuccessStoriesController::class)->except('update');
  Route::post('training-programs/{trainingProgram}', [App\Http\Controllers\Api\Admin\TrainingProgramsController::class, 'update'])->name('training-programs.update');
  Route::apiResource('training-programs', App\Http\Controllers\Api\Admin\TrainingProgramsController::class)->except('update');
  Route::apiResource('job-announcements', App\Http\Controllers\Api\Admin\JobAnnouncementController::class);
  Route::apiResource('publications', App\Http\Controllers\Api\Admin\PublicationsController::class);
  Route::apiResource('programs', App\Http\Controllers\Api\Admin\ProgramsController::class);
  Route::apiResource('agri-tech-tools', App\Http\Controllers\Api\Admin\AgriTechToolsController::class);
  Route::post('market-access-programs/{marketAccessProgram}', [App\Http\Controllers\Api\Admin\MarketAccessProgramsController::class, 'update'])->name('market-access-programs.update');
  Route::apiResource('market-access-programs', App\Http\Controllers\Api\Admin\MarketAccessProgramsController::class)->except('update');
  Route::post('smart-farming-programs/{smartFarmingProgram}', [App\Http\Controllers\Api\Admin\SmartFarmingProgramsController::class, 'update'])->name('smart-farming-programs.update');
  Route::apiResource('smart-farming-programs', App\Http\Controllers\Api\Admin\SmartFarmingProgramsController::class)->except('update');
  Route::post('seed-supply-programs/{seedSupplyProgram}', [App\Http\Controllers\Api\Admin\SeedSupplyProgramsController::class, 'update'])->name('seed-supply-programs.update');
  Route::apiResource('seed-supply-programs', App\Http\Controllers\Api\Admin\SeedSupplyProgramsController::class)->except('update');
  Route::post('community-programs/{communityProgram}', [App\Http\Controllers\Api\Admin\CommunityProgramsController::class, 'update'])->name('community-programs.update');
  Route::apiResource('community-programs', App\Http\Controllers\Api\Admin\CommunityProgramsController::class)->except('update');
  Route::post('environmental-projects/{environmentalProject}', [App\Http\Controllers\Api\Admin\EnvironmentalProjectsController::class, 'update'])->name('environmental-projects.update');
  Route::apiResource('environmental-projects', App\Http\Controllers\Api\Admin\EnvironmentalProjectsController::class)->except('update');
  Route::post('agri-tech-tools/{agriTechTool}', [App\Http\Controllers\Api\Admin\AgriTechToolsController::class, 'update'])->name('agri-tech-tools.update');
  Route::apiResource('agri-tech-tools', App\Http\Controllers\Api\Admin\AgriTechToolsController::class)->except('update');
  Route::apiResource('beneficiaries-stats', App\Http\Controllers\Api\Admin\BeneficiariesStatsController::class);
  Route::get('beneficiaries-stats-summary', [App\Http\Controllers\Api\Admin\BeneficiariesStatsController::class, 'summary'])->name('beneficiaries-stats.summary');
});
