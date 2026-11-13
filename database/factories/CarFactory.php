<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Car>
 */
class CarFactory extends Factory
{
    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = ['Toyota', 'BMW', 'Mercedes-Benz', 'Ford', 'Jeep', 'Audi', 'Lexus', 'Hyundai'];
        $brand = fake()->randomElement($brands);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $brand.' '.fake()->word(),
            'brand' => $brand,
            'model' => fake()->word(),
            'year' => fake()->numberBetween(2018, 2025),
            'price' => fake()->randomFloat(2, 15000, 95000),
            'mileage' => fake()->numberBetween(5000, 85000),
            'transmission' => fake()->randomElement(['Automatic', 'Manual']),
            'fuel_type' => fake()->randomElement(['Gasoline', 'Diesel', 'Hybrid', 'Electric']),
            'color' => fake()->safeColorName(),
            'country' => fake()->country(),
            'description' => fake()->paragraph(),
            'featured_image' => 'cars/'.fake()->numberBetween(1, 10).'.jpg',
            'status' => 'available',
        ];
    }
}
