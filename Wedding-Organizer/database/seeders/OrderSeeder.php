<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Catalogue;
use App\Models\User;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get published catalogues
        $catalogues = Catalogue::where('status_publish', 'published')->get();
        
        // Get all users
        $users = User::all();
        
        // Create orders for each catalogue
        foreach ($catalogues as $catalogue) {
            // Create 2-4 orders per catalogue
            $orderCount = rand(2, 4);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $randomUser = $users->random();
                
                Order::factory()->create([
                    'catalogue_id' => $catalogue->catalogue_id,
                    'user_id' => $randomUser->user_id,
                    'status' => rand(0, 1) ? 'requested' : 'approved',
                ]);
            }
        }
        
        // Create some additional random orders
        Order::factory(10)->create();
    }
}
