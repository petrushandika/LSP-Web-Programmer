<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default website settings
        Setting::factory()->create([
            'id' => 1,
            'website_name' => 'Elegant Wedding Organizer',
            'phone_number' => '+62 812-345-678',
            'email' => 'info@elegantwedding.com',
            'address' => 'Jl. Merdeka No. 123, Jakarta Pusat, DKI Jakarta 10110',
            'maps' => 'https://maps.google.com/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8341861!3d-6.2087634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f5390917b759%3A0x6b45e67356080477!2sMonas!5e0!3m2!1sen!2sid!4v1234567890123',
            'logo' => 'elegant-wedding-logo.png',
            'facebook_url' => 'https://facebook.com/elegantwedding',
            'instagram_url' => 'https://instagram.com/elegantwedding',
            'youtube_url' => 'https://youtube.com/c/elegantwedding',
            'header_business_hour' => 'Jam Operasional',
            'time_business_hour' => "Senin - Jumat: 09:00 - 17:00\nSabtu: 09:00 - 15:00\nMinggu: Tutup",
        ]);
    }
}
