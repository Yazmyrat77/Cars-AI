<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sedans',
                'slug' => 'sedans',
                'description' => 'Comfortable, stylish, and fuel-efficient executive vehicles for everyday driving.',
                'icon' => 'sedan',
            ],
            [
                'name' => 'Pickups',
                'slug' => 'pickups',
                'description' => 'Heavy-duty trucks built for power, towing capacity, and rugged utility.',
                'icon' => 'truck',
            ],
            [
                'name' => 'Jeeps',
                'slug' => 'jeeps',
                'description' => 'All-terrain 4x4 off-road beasts and robust luxury adventure SUVs.',
                'icon' => 'jeep',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
