<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Create 5 users with Indonesian names and role 'user'
        $indonesianUsers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'role' => 'user',
                'password' => 'password',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'role' => 'user',
                'password' => 'password',
            ],
            [
                'name' => 'Agus Prasetyo',
                'email' => 'agus@example.com',
                'role' => 'user',
                'password' => 'password',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'role' => 'user',
                'password' => 'password',
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@example.com',
                'role' => 'user',
                'password' => 'password',
            ],
        ];

        foreach ($indonesianUsers as $user) {
            User::factory()->create($user);
        }
    }
}
