<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmartFarmingProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Drip Irrigation System Implementation',
                'slug' => 'drip-irrigation-system-implementation',
                'description' => 'Learn to implement modern drip irrigation systems that reduce water usage by up to 50% while improving crop yields. This program covers system design, installation, maintenance, and water management techniques.',
                'short_description' => 'Modern drip irrigation systems for water-efficient farming',
                'farming_type' => 'drip_irrigation',
                'target_crops' => ['vegetables', 'fruits', 'cereals'],
                'sustainability_level' => 85,
                'implementation_guide' => 'Step-by-step guide to installing and maintaining drip irrigation systems, including water source setup, pipe installation, and emitter placement.',
                'sustainability_impact' => 'Reduces water usage by 50%, improves crop yields by 30%, and prevents soil erosion.',
                'duration' => '3 months',
                'location' => 'Kabul, Herat, Mazar-i-Sharif',
                'application_deadline' => now()->addMonths(2),
                'status' => 'published',
            ],
            [
                'name' => 'Greenhouse Farming Techniques',
                'slug' => 'greenhouse-farming-techniques',
                'description' => 'Master greenhouse farming for year-round production and protection from harsh weather. Learn about climate control, pest management, and optimal growing conditions.',
                'short_description' => 'Year-round farming in controlled environments',
                'farming_type' => 'greenhouse',
                'target_crops' => ['vegetables', 'fruits', 'spices'],
                'sustainability_level' => 90,
                'implementation_guide' => 'Complete guide to greenhouse construction, climate control systems, and crop management techniques.',
                'sustainability_impact' => 'Enables year-round production, reduces pesticide use by 60%, and increases yield by 200%.',
                'duration' => '6 months',
                'location' => 'Kabul, Kandahar, Balkh',
                'application_deadline' => now()->addMonths(3),
                'status' => 'published',
            ],
            [
                'name' => 'Precision Agriculture with GPS',
                'slug' => 'precision-agriculture-with-gps',
                'description' => 'Implement precision agriculture using GPS technology, soil sensors, and data analytics for optimized resource management and increased productivity.',
                'short_description' => 'Data-driven farming with GPS and sensors',
                'farming_type' => 'precision_agriculture',
                'target_crops' => ['cereals', 'vegetables', 'legumes'],
                'sustainability_level' => 75,
                'implementation_guide' => 'Training on GPS-guided equipment, soil testing, variable rate application, and data analysis.',
                'sustainability_impact' => 'Reduces fertilizer use by 25%, improves yield by 15%, and minimizes environmental impact.',
                'duration' => '4 months',
                'location' => 'Kabul, Herat, Nangarhar',
                'application_deadline' => now()->addMonths(1),
                'status' => 'published',
            ],
            [
                'name' => 'Organic Farming Practices',
                'slug' => 'organic-farming-practices',
                'description' => 'Learn chemical-free farming methods that promote soil health and environmental sustainability through natural pest control and organic fertilizers.',
                'short_description' => 'Chemical-free farming for healthy soil and environment',
                'farming_type' => 'organic',
                'target_crops' => ['vegetables', 'fruits', 'legumes', 'spices'],
                'sustainability_level' => 95,
                'implementation_guide' => 'Comprehensive guide to organic soil management, natural pest control, composting, and organic certification.',
                'sustainability_impact' => 'Eliminates chemical use, improves soil health, and produces premium organic crops.',
                'duration' => '5 months',
                'location' => 'Kabul, Bamyan, Badakhshan',
                'application_deadline' => now()->addMonths(2),
                'status' => 'published',
            ],
            [
                'name' => 'Climate-Resilient Crop Varieties',
                'slug' => 'climate-resilient-crop-varieties',
                'description' => 'Discover drought, heat, and flood-tolerant crop varieties adapted to changing climate conditions for sustainable agriculture.',
                'short_description' => 'Drought and heat-resistant crop varieties',
                'farming_type' => 'climate_resilient',
                'target_crops' => ['cereals', 'legumes', 'vegetables'],
                'sustainability_level' => 80,
                'implementation_guide' => 'Training on selecting and growing climate-resilient varieties, water management, and adaptation strategies.',
                'sustainability_impact' => 'Increases crop survival rate by 40% in extreme weather conditions.',
                'duration' => '3 months',
                'location' => 'Kabul, Kandahar, Kunduz',
                'application_deadline' => now()->addMonths(1),
                'status' => 'published',
            ],
            [
                'name' => 'Soil Health Management',
                'slug' => 'soil-health-management',
                'description' => 'Comprehensive soil testing, nutrient management, and erosion prevention strategies for long-term soil fertility and productivity.',
                'short_description' => 'Complete soil health and fertility management',
                'farming_type' => 'soil_health',
                'target_crops' => ['cereals', 'vegetables', 'legumes'],
                'sustainability_level' => 88,
                'implementation_guide' => 'Detailed soil testing procedures, nutrient management plans, and erosion control techniques.',
                'sustainability_impact' => 'Improves soil fertility by 35%, reduces erosion by 50%, and increases crop yields by 20%.',
                'duration' => '4 months',
                'location' => 'Kabul, Herat, Mazar-i-Sharif',
                'application_deadline' => now()->addMonths(2),
                'status' => 'published',
            ],
        ];

        foreach ($programs as $program) {
            \App\Models\SmartFarmingProgram::create($program);
        }
    }
}
