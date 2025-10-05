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
        
        if (!$adminUser) {
            // Create admin user if not exists
            $adminUser = User::create([
                'name' => 'Admin Wedding Organizer',
                'username' => 'admin',
                'email' => 'admin@weddingorganizer.com',
                'password' => bcrypt('admin123'),
            ]);
        }
        
        // Create comprehensive wedding packages
        $weddingPackages = [
            [
                'package_name' => 'Intimate Wedding Package',
                'description' => 'Perfect intimate wedding for 50-100 guests with elegant...',
                'price' => 15000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'package_name' => 'Classic Wedding Package',
                'description' => 'Traditional classic wedding for 100-200 guests with stunning...',
                'price' => 25000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'package_name' => 'Premium Wedding Package',
                'description' => 'Luxurious premium wedding for 200-300 guests with complete...',
                'price' => 45000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'package_name' => 'Luxury Wedding Package',
                'description' => 'Exclusive luxury wedding for 300-500 guests with VIP...',
                'price' => 75000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1465495976277-4387d4b0e4a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'package_name' => 'Garden Wedding Package',
                'description' => 'Beautiful outdoor garden wedding for 150-250 guests with...',
                'price' => 35000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'catalogue_id' => 6,
                'package_name' => 'Beach Wedding Package',
                'description' => 'Romantic beach wedding for 100-200 guests with sunset...',
                'price' => 40000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1519225421980-715cb0215aed?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'catalogue_id' => 7,
                'package_name' => 'Modern Wedding Package',
                'description' => 'Contemporary modern wedding for 150-300 guests with LED...',
                'price' => 50000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
            [
                'catalogue_id' => 8,
                'package_name' => 'Traditional Wedding Package',
                'description' => 'Cultural traditional wedding for 200-400 guests with authentic...',
                'price' => 60000000,
                'status_publish' => 'Y',
                'image' => 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'user_id' => $adminUser->user_id,
            ],
        ];
        
        // Insert wedding packages
        foreach ($weddingPackages as $package) {
            Catalogue::create($package);
        }
        
        // Create additional catalogues for other users if they exist
        $otherUsers = User::where('username', '!=', 'admin')->get();
        foreach ($otherUsers as $user) {
            Catalogue::factory(rand(2, 3))->forUser($user->user_id)->create();
        }
    }
}
