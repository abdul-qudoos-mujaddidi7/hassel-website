<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Publication;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\SuccessStory;
use App\Models\JobAnnouncement;
use App\Models\RfpRfq;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating core content...');

        // Create News Articles
        $this->command->line('- Creating news articles...');
        News::factory()->published()->count(15)->create();
        News::factory()->draft()->count(5)->create();

        // Create Publications
        $this->command->line('- Creating publications...');
        Publication::factory()->published()->report()->count(8)->create();
        Publication::factory()->published()->manual()->count(6)->create();
        Publication::factory()->published()->guideline()->count(5)->create();
        Publication::factory()->draft()->count(3)->create();

        // Create Success Stories
        $this->command->line('- Creating success stories...');
        SuccessStory::factory()->published()->farming()->count(8)->create();
        SuccessStory::factory()->published()->livestock()->count(4)->create();
        SuccessStory::factory()->draft()->count(2)->create();

        // Create Job Announcements
        $this->command->line('- Creating job announcements...');
        JobAnnouncement::factory()->open()->fullTime()->count(5)->create();
        JobAnnouncement::factory()->open()->contract()->count(3)->create();
        JobAnnouncement::factory()->closed()->count(8)->create();

        // Create RFP/RFQ
        $this->command->line('- Creating RFP/RFQ listings...');
        RfpRfq::factory()->open()->count(4)->create();
        RfpRfq::factory()->closed()->count(6)->create();

        // Create Galleries with Images
        $this->command->line('- Creating galleries...');
        $galleries = collect([
            Gallery::factory()->published()->farmingActivities()->create(),
            Gallery::factory()->published()->trainingEvents()->create(),
            Gallery::factory()->published()->projects()->create(),
            Gallery::factory()->published()->create(['title' => 'Community Outreach Programs']),
            Gallery::factory()->published()->create(['title' => 'Agricultural Innovation Showcase']),
        ]);

        // Add images to each gallery
        $galleries->each(function ($gallery) {
            GalleryImage::factory()
                ->forGallery($gallery)
                ->count(rand(5, 12))
                ->create();
        });

        $this->command->info('Core content created successfully!');
        $this->command->line('- News articles: 20 total (15 published, 5 draft)');
        $this->command->line('- Publications: 22 total (19 published, 3 draft)');
        $this->command->line('- Success stories: 14 total (12 published, 2 draft)');
        $this->command->line('- Job announcements: 16 total (8 open, 8 closed)');
        $this->command->line('- RFP/RFQ: 10 total (4 open, 6 closed)');
        $this->command->line('- Galleries: 5 galleries with images');
    }
}
