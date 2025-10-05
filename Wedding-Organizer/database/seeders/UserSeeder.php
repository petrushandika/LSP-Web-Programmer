<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'name' => 'Admin Wedding Organizer',
            'username' => 'admin',
            'email' => 'admin@weddingorganizer.com',
            'password' => bcrypt('admin123'),
        ]);

        // Create sample users
        User::factory(5)->create();
    }
}
