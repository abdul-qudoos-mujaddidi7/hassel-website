<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting Mount Agro Institution Database Seeding...');
        $this->command->newLine();

        // Seed in logical order
        $this->call([
            // 1. Create admin users first
        AdminUserSeeder::class,

            // 2. Create featured content
        NewsSeeder::class,
            // 3. Create all other content
        ContentSeeder::class,

            // 4. Create business pillar content
        BusinessPillarSeeder::class,
        // 5. Create success stories with translations
        SuccessStorySeeder::class,

        // 6. Create publications with translations
        PublicationSeeder::class,

        // 7. Create sample interactions and data
        SampleDataSeeder::class,
            
        TranslationsForAllContentSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->newLine();

        $this->command->line('📊 Summary of created content:');
        $this->command->line('👥 Users: 5 (1 admin, 4 editors/staff)');
        $this->command->line('📰 News: 23 articles (18 published, 5 draft)');
        $this->command->line('📚 Publications: 22 documents (19 published, 3 draft) with full translations');
        $this->command->line('🏆 Success Stories: 21 stories (21 published with full translations)');
        $this->command->line('💼 Job Announcements: 16 positions (8 open, 8 closed)');
        $this->command->line('📋 RFP/RFQ: 10 listings (4 open, 6 closed)');
        $this->command->line('🖼️ Galleries: 5 galleries with 35+ images');
        $this->command->line('🎓 Training Programs: 18 programs');
        $this->command->line('🔧 Agri-Tech Tools: 8 tools');
        $this->command->line('📈 Market Programs: 3 programs');
        $this->command->line('🌱 Environmental Projects: 3 projects');
        $this->command->line('👥 Community Programs: 3 programs');
        $this->command->line('📞 Sample Contacts: 15 inquiries');
        $this->command->line('📝 Program Registrations: 25 registrations');
        $this->command->line('📊 Statistics: 2 years of data');
        $this->command->line('🌐 Translations: Sample translations');

        $this->command->newLine();
        $this->command->line('🔑 Admin Login Credentials:');
        $this->command->line('Email: zakiullahsafi00@gmail.com');
        $this->command->line('Password: safi@123');
        $this->command->newLine();
        $this->command->line('✏️ Editor Login:');
        $this->command->line('Email: editor@mountagro.af');
        $this->command->line('Password: editor123456');
        $this->command->newLine();

        $this->command->info('🚀 Your Mount Agro Institution website is ready for demo and development!');
    }
}
