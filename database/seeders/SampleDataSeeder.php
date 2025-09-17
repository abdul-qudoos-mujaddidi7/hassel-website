<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\ProgramRegistration;
use App\Models\BeneficiariesStat;
use App\Models\Translation;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating sample interaction data...');

        // Create sample contacts
        $this->command->line('- Creating contact form submissions...');
        Contact::factory()->unread()->count(3)->create();
        Contact::factory()->replied()->count(4)->create();
        Contact::factory()->count(8)->create(); // Mixed statuses

        // Create sample program registrations
        $this->command->line('- Creating program registrations...');
        ProgramRegistration::factory()->pending()->count(5)->create();
        ProgramRegistration::factory()->approved()->count(8)->create();
        ProgramRegistration::factory()->completed()->count(12)->create();

        // Create sample beneficiaries statistics
        $this->command->line('- Creating beneficiaries statistics...');
        $stats = [
            // 2024 Statistics
            ['stat_type' => 'total_beneficiaries', 'value' => 2500, 'description' => 'Total people directly benefited from our programs', 'year' => 2024],
            ['stat_type' => 'male_beneficiaries', 'value' => 1400, 'description' => 'Male beneficiaries served', 'year' => 2024],
            ['stat_type' => 'female_beneficiaries', 'value' => 1100, 'description' => 'Female beneficiaries served', 'year' => 2024],
            ['stat_type' => 'programs_completed', 'value' => 45, 'description' => 'Training programs successfully completed', 'year' => 2024],
            ['stat_type' => 'provinces_reached', 'value' => 12, 'description' => 'Afghan provinces with active programs', 'year' => 2024],
            ['stat_type' => 'cooperatives_formed', 'value' => 25, 'description' => 'New farmer cooperatives established', 'year' => 2024],

            // 2023 Statistics
            ['stat_type' => 'total_beneficiaries', 'value' => 2100, 'description' => 'Total people directly benefited from our programs', 'year' => 2023],
            ['stat_type' => 'male_beneficiaries', 'value' => 1200, 'description' => 'Male beneficiaries served', 'year' => 2023],
            ['stat_type' => 'female_beneficiaries', 'value' => 900, 'description' => 'Female beneficiaries served', 'year' => 2023],
            ['stat_type' => 'programs_completed', 'value' => 38, 'description' => 'Training programs successfully completed', 'year' => 2023],
            ['stat_type' => 'provinces_reached', 'value' => 10, 'description' => 'Afghan provinces with active programs', 'year' => 2023],
            ['stat_type' => 'cooperatives_formed', 'value' => 20, 'description' => 'New farmer cooperatives established', 'year' => 2023],
        ];

        foreach ($stats as $stat) {
            BeneficiariesStat::create(array_merge($stat, [
                'created_at' => now()->subDays($stat['year'] == 2024 ? 30 : 365),
            ]));
        }

        // Create sample translations
        $this->command->line('- Creating sample translations...');
        $translations = [
            [
                'model_type' => 'App\\Models\\News',
                'model_id' => 1,
                'field_name' => 'title',
                'language' => 'pashto',
                'content' => 'د کرنې پرمختګ نوی پروګرام',
            ],
            [
                'model_type' => 'App\\Models\\News',
                'model_id' => 1,
                'field_name' => 'excerpt',
                'language' => 'pashto',
                'content' => 'د کشرانو لپاره د دوامدارۍ وده کولو ځانګړی پور پروګرام',
            ],
            [
                'model_type' => 'App\\Models\\News',
                'model_id' => 1,
                'field_name' => 'title',
                'language' => 'farsi',
                'content' => 'برنامه جدید توسعه کشاورزی',
            ],
            [
                'model_type' => 'App\\Models\\Publication',
                'model_id' => 1,
                'field_name' => 'title',
                'language' => 'pashto',
                'content' => 'د دوامدارې کرنې لارښوونه',
            ],
        ];

        foreach ($translations as $translation) {
            Translation::create($translation);
        }

        $this->command->info('Sample data created successfully!');
        $this->command->line('- Contact submissions: 15 entries (3 unread, 4 replied, 8 mixed)');
        $this->command->line('- Program registrations: 25 entries (5 pending, 8 approved, 12 completed)');
        $this->command->line('- Beneficiaries statistics: 12 stat entries (2 years of data)');
        $this->command->line('- Sample translations: 4 entries');
    }
}
