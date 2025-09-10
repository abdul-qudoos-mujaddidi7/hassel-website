<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'New Agricultural Loan Program Launch',
                'slug' => 'new-agricultural-loan-program-launch',
                'excerpt' => 'A tailored loan program for smallholder farmers to scale sustainably.',
                'content' => 'HMI is proud to announce the launch of our new Agricultural Loan Program, specifically designed to support smallholder farmers in scaling their operations sustainably. This program offers flexible terms and competitive rates to help farmers invest in modern equipment, seeds, and irrigation systems.',
                'featured_image' => 'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'HMI Expands to New Regions',
                'slug' => 'hmi-expands-to-new-regions',
                'excerpt' => 'Services now available in three additional provinces.',
                'content' => 'We are excited to announce the expansion of HMI services to three new provinces: Balkh, Nangarhar, and Kandahar. This expansion brings our financial services closer to rural communities and agricultural areas that need them most.',
                'featured_image' => 'https://images.unsplash.com/photo-1620228885847-9eab2a1adddc?auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Partnership with Global Finance Initiative',
                'slug' => 'partnership-with-global-finance-initiative',
                'excerpt' => 'Bringing innovative finance to rural entrepreneurs.',
                'content' => 'HMI has entered into a strategic partnership with the Global Finance Initiative to bring innovative financial products and services to rural entrepreneurs across Afghanistan. This partnership will help us reach more underserved communities.',
                'featured_image' => 'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1200&q=80',
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}
