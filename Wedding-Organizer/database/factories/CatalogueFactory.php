<?php

namespace Database\Factories;

use App\Models\Catalogue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalogue>
 */
class CatalogueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Catalogue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'catalogue_id' => fake()->unique()->numberBetween(1, 99999),
            'image' => fake()->imageUrl(640, 480, 'wedding', true),
            'package_name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(5000000, 50000000),
            'status_publish' => fake()->randomElement(['Y', 'N']),
        ];
    }

    /**
     * Indicate that the catalogue should be published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_publish' => 'Y',
        ]);
    }

    /**
     * Indicate that the catalogue should be unpublished.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'status_publish' => 'N',
        ]);
    }

    /**
     * Indicate that the catalogue should belong to a specific user.
     */
    public function forUser(int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $userId,
        ]);
    }
}