<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Catalogue;
use App\Models\User;

class CatalogueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user
        $adminUser = User::where('username', 'admin')->first();
        
        // Create published catalogues for admin
        Catalogue::factory(8)->published()->forUser($adminUser->user_id)->create();
        
        // Create unpublished catalogues for admin
        Catalogue::factory(3)->unpublished()->forUser($adminUser->user_id)->create();
        
        // Create catalogues for other users
        $otherUsers = User::where('username', '!=', 'admin')->get();
        foreach ($otherUsers as $user) {
            Catalogue::factory(rand(2, 5))->forUser($user->user_id)->create();
        }
    }
}
