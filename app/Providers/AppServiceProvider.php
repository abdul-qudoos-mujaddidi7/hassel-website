<?php

namespace App\Providers;

use App\Models\CommunityProgram;
use App\Models\MarketAccessProgram;
use App\Models\TrainingProgram;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();

        // When behind a reverse proxy (e.g., Cloudflare Tunnel), ensure
        // generated URLs (asset(), url(), @vite) use HTTPS to avoid mixed content.
        $forwardedProto = $_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null;
        if ($forwardedProto === 'https') {
            URL::forceScheme('https');
        }

        Relation::enforceMorphMap([
            'training_program' => TrainingProgram::class,
            'market_access_program' => MarketAccessProgram::class,
            'community_program' => CommunityProgram::class,
        ]);
    }
}
