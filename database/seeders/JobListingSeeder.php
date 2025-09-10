<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;

class JobListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Loan Officer',
                'description' => 'Responsible for managing loan portfolios, client relationships, and ensuring compliance with HMI policies. You will work directly with farmers and entrepreneurs to provide financial solutions.',
                'location' => 'Kabul',
                'type' => 'full-time',
                'requirements' => ['Bachelor degree in Finance or related field', '2+ years experience in microfinance', 'Strong communication skills', 'Knowledge of local languages'],
                'benefits' => ['Competitive salary', 'Health insurance', 'Professional development opportunities', 'Flexible working hours'],
                'salary_min' => 50000,
                'salary_max' => 70000,
                'application_deadline' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'title' => 'Field Coordinator',
                'description' => 'Coordinate field operations, manage regional teams, and ensure effective service delivery in rural areas. This role involves significant travel to remote locations.',
                'location' => 'Herat',
                'type' => 'full-time',
                'requirements' => ['Master degree in Development Studies or related field', '3+ years experience in rural development', 'Leadership skills', 'Willingness to travel'],
                'benefits' => ['Competitive salary', 'Travel allowance', 'Health insurance', 'Housing allowance'],
                'salary_min' => 60000,
                'salary_max' => 80000,
                'application_deadline' => now()->addDays(25),
                'is_active' => true,
            ],
            [
                'title' => 'IT Support Specialist',
                'description' => 'Provide technical support for HMI\'s IT systems, maintain databases, and ensure system security. You will work with our core banking system and other digital tools.',
                'location' => 'Kabul',
                'type' => 'full-time',
                'requirements' => ['Bachelor degree in Computer Science or related field', '2+ years experience in IT support', 'Database management skills', 'System security knowledge'],
                'benefits' => ['Competitive salary', 'Health insurance', 'Training opportunities', 'Modern equipment'],
                'salary_min' => 45000,
                'salary_max' => 65000,
                'application_deadline' => now()->addDays(20),
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Officer',
                'description' => 'Develop and implement marketing strategies to promote HMI\'s services and reach new clients. You will work on digital marketing, content creation, and brand management.',
                'location' => 'Kabul',
                'type' => 'full-time',
                'requirements' => ['Bachelor degree in Marketing or related field', '2+ years experience in marketing', 'Digital marketing skills', 'Content creation abilities'],
                'benefits' => ['Competitive salary', 'Health insurance', 'Creative freedom', 'Professional development'],
                'salary_min' => 40000,
                'salary_max' => 60000,
                'application_deadline' => now()->addDays(15),
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $job) {
            JobListing::create($job);
        }
    }
}
