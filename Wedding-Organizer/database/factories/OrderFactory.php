<?php

namespace Database\Factories;

use App\Models\Catalogue;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get existing catalogue IDs to ensure foreign key constraint
        $catalogueIds = Catalogue::pluck('catalogue_id')->toArray();
        $catalogueId = !empty($catalogueIds) ? fake()->randomElement($catalogueIds) : 1;
        
        return [
            'order_id' => fake()->unique()->numberBetween(1, 99999),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'wedding_date' => fake()->dateTimeBetween('+1 month', '+2 years'),
            'status' => fake()->randomElement(['requested', 'approved']),
            'catalogue_id' => $catalogueId,
            'user_id' => 1, // Default to admin user
        ];
    }

    /**
     * Indicate that the order should belong to a specific catalogue.
     */
    public function forCatalogue(int $catalogueId): static
    {
        return $this->state(fn (array $attributes) => [
            'catalogue_id' => $catalogueId,
        ]);
    }

    /**
     * Indicate that the order should belong to a specific user.
     */
    public function forUser(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId,
        ]);
    }

    /**
     * Indicate that the order should have a specific status.
     */
    public function withStatus(string $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => $status,
        ]);
    }
}