<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin user already exists
        $existingAdmin = User::where('username', 'petrushandika')
                            ->orWhere('email', 'petrushandikasinaga@gmail.com')
                            ->first();

        if (!$existingAdmin) {
            User::create([
                'name' => 'Petrus Handika',
                'username' => 'petrushandika',
                'email' => 'petrushandikasinaga@gmail.com',
                'password' => Hash::make('petrushandika'),
                'phone_number' => '081573018140',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat, DKI Jakarta 10110',
                'role' => 'admin',
            ]);
            
            echo "Admin user 'Petrus Handika' created successfully.\n";
        } else {
            echo "Admin user already exists. Skipping creation.\n";
        }
    }
}
