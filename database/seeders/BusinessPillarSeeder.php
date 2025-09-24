<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TrainingProgram;
use App\Models\AgriTechTool;
use App\Models\MarketAccessProgram;
use App\Models\EnvironmentalProject;
use App\Models\CommunityProgram;

class BusinessPillarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating business pillar content...');

        // Create Training Programs
        $this->command->line('- Creating training programs...');
        TrainingProgram::factory()->upcoming()->count(5)->create();
        TrainingProgram::factory()->ongoing()->count(3)->create();
        TrainingProgram::factory()->completed()->count(10)->create();

        // Create Agri-Tech Tools
        $this->command->line('- Creating agri-tech tools...');
        AgriTechTool::factory()->published()->count(8)->create();

        // Create Market Access Programs
        $this->command->line('- Creating market access programs...');
        $marketPrograms = [
            [
                'title' => 'Farmers Market Direct Sales Program',
                'description' => 'Connect farmers directly with urban consumers through weekly farmers markets.',
                'program_type' => 'direct_sales',
                'target_crops' => 'vegetables,fruits',
                'status' => 'published',
            ],
            [
                'title' => 'Value Chain Development Initiative',
                'description' => 'Comprehensive program to strengthen agricultural value chains from farm to market.',
                'program_type' => 'value_chain',
                'target_crops' => 'wheat,rice,corn',
                'status' => 'published',
            ],
            [
                'title' => 'Export Readiness Training',
                'description' => 'Prepare farmers and cooperatives for international market opportunities.',
                'program_type' => 'export_support',
                'target_crops' => 'fruits,nuts,spices',
                'status' => 'published',
            ],
        ];

        foreach ($marketPrograms as $program) {
            MarketAccessProgram::create(array_merge($program, [
                'slug' => \Illuminate\Support\Str::slug($program['title']),
                'target_crops' => json_encode(explode(',', $program['target_crops'])),
                'cover_image' => '/images/seed/covers/cover' . rand(1, 3) . '.jpg',
                'thumbnail_image' => '/images/seed/thumbs/thumb' . rand(1, 3) . '.jpg',
                'created_at' => now()->subDays(rand(1, 365)),
            ]));
        }

        // Create Environmental Projects
        $this->command->line('- Creating environmental projects...');
        $envProjects = [
            [
                'title' => 'Watershed Management Initiative',
                'description' => 'Comprehensive watershed restoration and management project.',
                'project_type' => 'water_management',
                'location' => 'Kabul Province',
                'status' => 'published',
            ],
            [
                'title' => 'Soil Conservation Program',
                'description' => 'Large-scale soil erosion prevention and fertility restoration project.',
                'project_type' => 'soil_conservation',
                'location' => 'Herat Province',
                'status' => 'published',
            ],
            [
                'title' => 'Reforestation and Agroforestry',
                'description' => 'Tree planting and agroforestry systems development program.',
                'project_type' => 'reforestation',
                'location' => 'Bamyan Province',
                'status' => 'published',
            ],
        ];

        foreach ($envProjects as $project) {
            EnvironmentalProject::create(array_merge($project, [
                'slug' => \Illuminate\Support\Str::slug($project['title']),
                'cover_image' => '/images/seed/covers/cover' . rand(1, 3) . '.jpg',
                'thumbnail_image' => '/images/seed/thumbs/thumb' . rand(1, 3) . '.jpg',
                'created_at' => now()->subDays(rand(1, 365)),
            ]));
        }

        // Create Community Programs
        $this->command->line('- Creating community programs...');
        $communityPrograms = [
            [
                'title' => 'Women in Agriculture Leadership',
                'description' => 'Empowering women farmers through leadership training and cooperative development.',
                'program_type' => 'leadership',
                'target_group' => 'women',
                'location' => 'Multiple Provinces',
                'status' => 'published',
            ],
            [
                'title' => 'Youth Agricultural Entrepreneurship',
                'description' => 'Supporting young people in starting agricultural businesses and cooperatives.',
                'program_type' => 'entrepreneurship',
                'target_group' => 'youth',
                'location' => 'Urban and Rural Areas',
                'status' => 'published',
            ],
            [
                'title' => 'Farmers Cooperative Development',
                'description' => 'Strengthening existing cooperatives and forming new farmer organizations.',
                'program_type' => 'capacity_building',
                'target_group' => 'farmers',
                'location' => 'Rural Communities',
                'status' => 'published',
            ],
        ];

        foreach ($communityPrograms as $program) {
            CommunityProgram::create(array_merge($program, [
                'slug' => \Illuminate\Support\Str::slug($program['title']),
                'cover_image' => '/images/seed/covers/cover' . rand(1, 3) . '.jpg',
                'thumbnail_image' => '/images/seed/thumbs/thumb' . rand(1, 3) . '.jpg',
                'created_at' => now()->subDays(rand(1, 365)),
            ]));
        }

        $this->command->info('Business pillar content created successfully!');
        $this->command->line('- Training programs: 18 total (5 upcoming, 3 ongoing, 10 completed)');
        $this->command->line('- Agri-tech tools: 5 published tools');
        $this->command->line('- Market access programs: 3 published programs');
        $this->command->line('- Environmental projects: 3 published projects');
        $this->command->line('- Community programs: 3 published programs');
    }
}
