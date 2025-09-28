<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedSupplyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'High-Quality Wheat Seeds',
                'slug' => 'high-quality-wheat-seeds',
                'description' => 'Premium wheat seeds with high germination rates, disease resistance, and improved yield potential. Certified quality assurance with 95% germination rate.',
                'short_description' => 'Premium wheat seeds with 95% germination rate',
                'input_type' => 'seeds',
                'target_crops' => ['cereals'],
                'quality_grade' => 'Premium',
                'price_range' => '$15-25 per kg',
                'availability' => 'In Stock',
                'shelf_life' => '2 years',
                'distribution_centers' => ['Kabul', 'Herat', 'Mazar-i-Sharif', 'Kandahar'],
                'usage_instructions' => 'Plant 2-3 inches deep in well-prepared soil. Water regularly and apply fertilizer as needed.',
                'technical_specifications' => 'Germination rate: 95%, Purity: 99%, Moisture content: 12%, Disease resistance: High',
                'supplier' => 'Afghan Agriculture Seeds Co.',
                'contact_info' => 'Phone: +93-70-123-4567, Email: seeds@afghanagri.af',
                'status' => 'published',
            ],
            [
                'name' => 'Organic Fertilizer Blend',
                'slug' => 'organic-fertilizer-blend',
                'description' => 'Eco-friendly organic fertilizer that improves soil health while boosting crop productivity. Made from natural compost and beneficial microorganisms.',
                'short_description' => 'Natural organic fertilizer for healthy soil',
                'input_type' => 'fertilizers',
                'target_crops' => ['vegetables', 'fruits', 'cereals'],
                'quality_grade' => 'A',
                'price_range' => '$8-12 per bag',
                'availability' => 'In Stock',
                'shelf_life' => '6 months',
                'distribution_centers' => ['Kabul', 'Herat', 'Balkh', 'Nangarhar'],
                'usage_instructions' => 'Apply 2-3 kg per 100 sq meters. Mix with soil before planting or apply as top dressing.',
                'technical_specifications' => 'NPK: 5-3-2, Organic matter: 60%, pH: 6.5-7.0',
                'supplier' => 'Green Earth Fertilizers',
                'contact_info' => 'Phone: +93-70-234-5678, Email: organic@greenearth.af',
                'status' => 'published',
            ],
            [
                'name' => 'Eco-Friendly Pesticides',
                'slug' => 'eco-friendly-pesticides',
                'description' => 'Biodegradable pest control solutions that protect crops without harming beneficial insects or the environment. Safe for organic farming.',
                'short_description' => 'Safe biodegradable pest control solutions',
                'input_type' => 'pesticides',
                'target_crops' => ['vegetables', 'fruits', 'spices'],
                'quality_grade' => 'Standard',
                'price_range' => '$20-35 per liter',
                'availability' => 'Limited',
                'shelf_life' => '1 year',
                'distribution_centers' => ['Kabul', 'Herat', 'Kandahar'],
                'usage_instructions' => 'Dilute 1:100 with water. Apply early morning or evening. Reapply every 7-10 days as needed.',
                'technical_specifications' => 'Active ingredient: Neem extract, Biodegradable: Yes, Safe for beneficial insects: Yes',
                'supplier' => 'Natural Pest Solutions',
                'contact_info' => 'Phone: +93-70-345-6789, Email: natural@pestsolutions.af',
                'status' => 'published',
            ],
            [
                'name' => 'Drip Irrigation Equipment',
                'slug' => 'drip-irrigation-equipment',
                'description' => 'Complete drip irrigation system including pipes, emitters, filters, and timers. Easy to install and maintain for water-efficient farming.',
                'short_description' => 'Complete drip irrigation system for water efficiency',
                'input_type' => 'equipment',
                'target_crops' => ['vegetables', 'fruits'],
                'quality_grade' => 'Premium',
                'price_range' => '$200-500 per set',
                'availability' => 'In Stock',
                'shelf_life' => '5 years',
                'distribution_centers' => ['Kabul', 'Herat', 'Mazar-i-Sharif', 'Kandahar', 'Balkh'],
                'usage_instructions' => 'Install main line, connect emitters, set timer. Regular cleaning of filters recommended.',
                'technical_specifications' => 'Pipe diameter: 16mm, Emitter flow: 2L/hour, Pressure: 1-3 bar',
                'supplier' => 'Irrigation Solutions Ltd.',
                'contact_info' => 'Phone: +93-70-456-7890, Email: irrigation@solutions.af',
                'status' => 'published',
            ],
            [
                'name' => 'Greenhouse Construction Materials',
                'slug' => 'greenhouse-construction-materials',
                'description' => 'High-quality materials for greenhouse construction including frames, covering, ventilation systems, and climate control equipment.',
                'short_description' => 'Complete greenhouse construction materials',
                'input_type' => 'tools',
                'target_crops' => ['vegetables', 'fruits', 'spices'],
                'quality_grade' => 'A',
                'price_range' => '$1000-3000 per unit',
                'availability' => 'In Stock',
                'shelf_life' => '10 years',
                'distribution_centers' => ['Kabul', 'Herat', 'Balkh'],
                'usage_instructions' => 'Professional installation recommended. Follow assembly instructions carefully.',
                'technical_specifications' => 'Frame: Galvanized steel, Covering: UV-resistant plastic, Size: 6x8 meters',
                'supplier' => 'Greenhouse Specialists',
                'contact_info' => 'Phone: +93-70-567-8901, Email: greenhouse@specialists.af',
                'status' => 'published',
            ],
            [
                'name' => 'Soil Testing Kit',
                'slug' => 'soil-testing-kit',
                'description' => 'Complete soil testing kit for analyzing pH, nutrients, and soil composition. Essential for precision agriculture and soil health management.',
                'short_description' => 'Complete soil analysis testing kit',
                'input_type' => 'tools',
                'target_crops' => ['cereals', 'vegetables', 'legumes'],
                'quality_grade' => 'Standard',
                'price_range' => '$50-80 per kit',
                'availability' => 'In Stock',
                'shelf_life' => '2 years',
                'distribution_centers' => ['Kabul', 'Herat', 'Mazar-i-Sharif', 'Kandahar'],
                'usage_instructions' => 'Collect soil samples, follow testing procedures, interpret results using provided guide.',
                'technical_specifications' => 'Tests: pH, N, P, K, Organic matter, Includes: Testing strips, reagents, guide',
                'supplier' => 'Soil Analysis Co.',
                'contact_info' => 'Phone: +93-70-678-9012, Email: soil@analysis.af',
                'status' => 'published',
            ],
        ];

        foreach ($programs as $program) {
            \App\Models\SeedSupplyProgram::create($program);
        }
    }
}
