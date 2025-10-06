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

        // Use morphMap (non-enforced) so existing rows that store full class names continue working
        Relation::morphMap([
            'user' => \App\Models\User::class,
            'news' => \App\Models\News::class,
            'publication' => \App\Models\Publication::class,
            'success_story' => \App\Models\SuccessStory::class,
            'training_program' => TrainingProgram::class,
            'agri_tech_tool' => \App\Models\AgriTechTool::class,
            'smart_farming_program' => \App\Models\SmartFarmingProgram::class,
            'seed_supply_program' => \App\Models\SeedSupplyProgram::class,
            'market_access_program' => MarketAccessProgram::class,
            'environmental_project' => \App\Models\EnvironmentalProject::class,
            'community_program' => CommunityProgram::class,
            'job_announcement' => \App\Models\JobAnnouncement::class,
            'gallery' => \App\Models\Gallery::class,
            'gallery_image' => \App\Models\GalleryImage::class,
        ]);
    }
}
