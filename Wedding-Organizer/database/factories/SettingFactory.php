<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->numberBetween(1, 99999),
            'website_name' => fake()->company() . ' Wedding Organizer',
            'phone_number' => '+62 ' . fake()->numerify('###-####-###'),
            'email' => fake()->companyEmail(),
            'address' => fake()->address(),
            'maps' => fake()->url(),
            'logo' => fake()->imageUrl(200, 200, 'business', true),
            'facebook_url' => fake()->url(),
            'instagram_url' => fake()->url(),
            'youtube_url' => fake()->url(),
            'header_business_hour' => 'Business Hours',
            'time_business_hour' => 'Monday - Friday: 9:00 AM - 6:00 PM',
        ];
    }

    /**
     * Indicate that the setting should have a specific website name.
     */
    public function withWebsiteName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'website_name' => $name,
        ]);
    }

    /**
     * Indicate that the setting should have specific contact information.
     */
    public function withContact(string $phone, string $email, string $address): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_number' => $phone,
            'email' => $email,
            'address' => $address,
        ]);
    }
}