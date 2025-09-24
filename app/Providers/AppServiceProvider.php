<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // When behind a reverse proxy (e.g., Cloudflare Tunnel), ensure
        // generated URLs (asset(), url(), @vite) use HTTPS to avoid mixed content.
        $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null;
        if ($forwardedProto === 'https') {
            URL::forceScheme('https');
        }
    }
}
