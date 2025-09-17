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
                'title' => 'Mount Agro Institution Launches New Agricultural Development Program',
                'slug' => 'mount-agro-institution-launches-new-agricultural-development-program',
                'excerpt' => 'A comprehensive program designed to support sustainable farming practices and increase agricultural productivity across Afghanistan.',
                'content' => 'Mount Agro Institution is proud to announce the launch of our new Agricultural Development Program, specifically designed to support farmers across Afghanistan in adopting sustainable farming practices. This comprehensive program combines traditional knowledge with modern agricultural techniques to increase productivity while preserving environmental resources.

The program includes training workshops, technical assistance, access to improved seeds and equipment, and ongoing support for participating farmers. Our team of agricultural experts will work directly with farming communities to implement best practices in soil management, water conservation, and crop diversification.

Initial pilot projects have shown promising results, with participating farms experiencing an average 35% increase in crop yields while reducing water usage by 20%. The program is expected to reach over 5,000 farmers across 15 provinces in its first year.',
                'featured_image' => 'https://images.unsplash.com/photo-1625246335525-4d50c8507f68?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
            ],
            [
                'title' => 'Successful Harvest Season Results from Training Programs',
                'slug' => 'successful-harvest-season-results-from-training-programs',
                'excerpt' => 'Farmers who participated in our training programs report significant improvements in crop quality and yield.',
                'content' => 'The latest harvest season has brought excellent news from farmers who participated in Mount Agro Institution\'s training programs throughout the year. Across multiple provinces, participating farmers have reported substantial improvements in both crop quality and overall yield.

Key achievements include:
- Average yield increase of 40% for wheat crops
- 25% improvement in vegetable production quality
- Reduced post-harvest losses by 30%
- Enhanced soil health through sustainable practices

These results demonstrate the effectiveness of combining traditional farming wisdom with modern agricultural techniques. Our field teams have documented best practices and success stories that will be shared with the broader farming community.

The success of this season\'s harvest validates our approach to agricultural development and reinforces our commitment to supporting Afghanistan\'s farming communities. We look forward to expanding these programs to reach even more farmers in the coming year.',
                'featured_image' => 'https://images.unsplash.com/photo-1605000797499-95a51c5269ae?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
                'published_at' => now()->subDays(15),
                'created_at' => now()->subDays(15),
            ],
            [
                'title' => 'Partnership with International Agricultural Research Center',
                'slug' => 'partnership-with-international-agricultural-research-center',
                'excerpt' => 'New collaboration brings cutting-edge research and technology to Afghan farmers.',
                'content' => 'Mount Agro Institution has entered into a strategic partnership with the International Center for Agricultural Research in Dry Areas (ICARDA) to bring advanced research and technology to Afghanistan\'s agricultural sector.

This partnership will focus on:
- Development of drought-resistant crop varieties
- Climate-smart agriculture techniques
- Soil and water conservation methods
- Capacity building for local researchers
- Technology transfer and innovation adoption

The collaboration includes joint research projects, training exchanges, and the establishment of demonstration farms where new techniques can be tested and refined for local conditions. This partnership represents a significant step forward in advancing agricultural science and practice in Afghanistan.

Initial projects will focus on developing wheat varieties better adapted to changing climate conditions and improving water use efficiency in irrigation systems. The partnership is expected to benefit thousands of farmers across the country through improved agricultural technologies and practices.',
                'featured_image' => 'https://images.unsplash.com/photo-1532619187608-e5375cab36aa?auto=format&fit=crop&w=1200&q=80',
                'status' => 'published',
                'published_at' => now()->subDays(25),
                'created_at' => now()->subDays(25),
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }

        $this->command->info('Featured news articles created successfully!');
    }
}