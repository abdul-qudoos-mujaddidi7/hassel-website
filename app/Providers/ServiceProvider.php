<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use App\Services\FileUploadService;
use App\Services\EmailService;
use App\Services\ImageOptimizationService;

class ServiceProvider extends BaseServiceProvider
{
  /**
   * Register services.
   */
  public function register(): void
  {
    // Register services as singletons
    $this->app->singleton(FileUploadService::class, function ($app) {
      return new FileUploadService();
    });

    $this->app->singleton(EmailService::class, function ($app) {
      return new EmailService();
    });

    $this->app->singleton(ImageOptimizationService::class, function ($app) {
      return new ImageOptimizationService();
    });
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    //
  }
}
