<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main admin user
        User::create([
            'name' => 'Zakiullah Safi',
            'email' => 'zakiullahsafi00@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('safi@123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create editor user
        User::create([
            'name' => 'Content Editor',
            'email' => 'editor@mountagro.af',
            'email_verified_at' => now(),
            'password' => Hash::make('editor123456'),
            'role' => 'editor',
            'status' => 'active',
        ]);

        // Create additional admin users with realistic names
        $adminUsers = [
            [
                'name' => 'Ahmad Hassan',
                'email' => 'ahmad.hassan@mountagro.af',
                'role' => 'admin',
            ],
            [
                'name' => 'Fatima Nazari',
                'email' => 'fatima.nazari@mountagro.af',
                'role' => 'editor',
            ],
            [
                'name' => 'Mohammad Karimi',
                'email' => 'mohammad.karimi@mountagro.af',
                'role' => 'editor',
            ],
            [
                'name' => 'Jawad',
                'email' => 'jawad@gmail.con',
                'role' => 'admin',
            ],
        ];

        foreach ($adminUsers as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'role' => $userData['role'],
                'status' => 'active',
            ]);
        }

        $this->command->info('Admin users created successfully!');
        $this->command->line('Main Admin: zakiullahsafi00@gmail.com / safi@123');
        $this->command->line('Editor: editor@mountagro.af / editor123456');
        $this->command->line('Admin: jawad@gmail.con / password123');
    }
}
