<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sedans = Category::where('slug', 'sedans')->first();
        $pickups = Category::where('slug', 'pickups')->first();
        $jeeps = Category::where('slug', 'jeeps')->first();

        $admin = User::where('username', 'admin')->first();
        $john = User::where('username', 'johndoe')->first();
        $dealer = User::where('username', 'elite_motors')->first();
        $elena = User::where('username', 'elena_r')->first();

        $carsData = [
            // SEDANS
            [
                'category_id' => $sedans->id,
                'user_id' => $dealer->id,
                'title' => 'Hyundai Elantra N-Line 2024',
                'brand' => 'Hyundai',
                'model' => 'Elantra',
                'year' => 2024,
                'price' => 38500.00,
                'mileage' => 12000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'color' => 'Cyber Gray',
                'country' => 'USA',
                'description' => 'Sporty, modern sedan featuring cutting-edge infotainment, heated seats, lane keep assist, and aggressive aerodynamic styling.',
                'featured_image' => 'cars/10.jpg',
                'status' => 'available',
                'gallery' => ['cars/10.jpg', 'cars/1.jpg'],
                'reviews' => [
                    ['user_id' => $john->id, 'rating' => 5, 'comment' => 'Incredible fuel economy and very smooth handling on the highway!'],
                    ['user_id' => $elena->id, 'rating' => 4, 'comment' => 'Modern interior with great ambient lighting. Loved the infotainment.'],
                ],
            ],
            [
                'category_id' => $sedans->id,
                'user_id' => $john->id,
                'title' => 'Toyota Camry XSE V6 2025',
                'brand' => 'Toyota',
                'model' => 'Camry',
                'year' => 2025,
                'price' => 42000.00,
                'mileage' => 4500,
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'color' => 'Magnetic Gray Metallic',
                'country' => 'Germany',
                'description' => 'The benchmark of reliable luxury sedans. Equipped with panoramic sunroof, JBL premium sound system, and Toyota Safety Sense 3.0.',
                'featured_image' => 'cars/9.jpg',
                'status' => 'available',
                'gallery' => ['cars/9.jpg', 'cars/8.jpg'],
                'reviews' => [
                    ['user_id' => $admin->id, 'rating' => 5, 'comment' => 'Unbeatable reliability and comfort. Drives like a cloud.'],
                ],
            ],
            [
                'category_id' => $sedans->id,
                'user_id' => $dealer->id,
                'title' => 'Lexus IS 500 F-Sport Performance',
                'brand' => 'Lexus',
                'model' => 'IS 500',
                'year' => 2023,
                'price' => 54000.00,
                'mileage' => 18000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'color' => 'Caviar Gray',
                'country' => 'UK',
                'description' => 'Naturally aspirated 5.0L V8 producing 472 horsepower. Luxurious red leather cabin, active sport exhaust, and premium Mark Levinson audio.',
                'featured_image' => 'cars/8.jpg',
                'status' => 'available',
                'gallery' => ['cars/8.jpg', 'cars/1.jpg'],
                'reviews' => [
                    ['user_id' => $john->id, 'rating' => 5, 'comment' => 'The sound of that V8 is pure symphony. Truly a masterpiece!'],
                ],
            ],

            // PICKUPS
            [
                'category_id' => $pickups->id,
                'user_id' => $dealer->id,
                'title' => 'Ford F-150 Lariat 4x4 PowerBoost',
                'brand' => 'Ford',
                'model' => 'F-150',
                'year' => 2023,
                'price' => 64500.00,
                'mileage' => 25000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Hybrid',
                'color' => 'Oxford White',
                'country' => 'USA',
                'description' => 'America\'s favorite truck with 7.2kW Pro Power Onboard generator, 14,000 lbs towing capacity, and max recline luxury seating.',
                'featured_image' => 'cars/3.jpg',
                'status' => 'available',
                'gallery' => ['cars/3.jpg', 'cars/4.jpg'],
                'reviews' => [
                    ['user_id' => $elena->id, 'rating' => 5, 'comment' => 'Towed our boat effortlessly across mountain passes. Best truck ever.'],
                ],
            ],
            [
                'category_id' => $pickups->id,
                'user_id' => $admin->id,
                'title' => 'RAM 1500 TRX 6.2L Supercharged',
                'brand' => 'RAM',
                'model' => '1500 TRX',
                'year' => 2025,
                'price' => 92000.00,
                'mileage' => 8000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'color' => 'Diamond Black Crystal',
                'country' => 'USA',
                'description' => 'Supercharged 702hp HEMI monster truck. Bilstein Black Hawk e2 active dampers, 35-inch Goodyear all-terrain tires, and launch control.',
                'featured_image' => 'cars/4.jpg',
                'status' => 'available',
                'gallery' => ['cars/4.jpg', 'cars/3.jpg'],
                'reviews' => [
                    ['user_id' => $dealer->id, 'rating' => 5, 'comment' => 'Unbelievable acceleration for a pickup. Turns heads everywhere!'],
                ],
            ],
            [
                'category_id' => $pickups->id,
                'user_id' => $john->id,
                'title' => 'Toyota Hilux GR Sport 4WD',
                'brand' => 'Toyota',
                'model' => 'Hilux',
                'year' => 2024,
                'price' => 45000.00,
                'mileage' => 15000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Diesel',
                'color' => 'Titanium Silver',
                'country' => 'Germany',
                'description' => 'Legendary invulnerability with GR-tuned suspension, heavy duty skid plates, locking rear differential, and bulletproof turbo-diesel.',
                'featured_image' => 'cars/2.jpg',
                'status' => 'available',
                'gallery' => ['cars/2.jpg', 'cars/3.jpg'],
                'reviews' => [
                    ['user_id' => $admin->id, 'rating' => 5, 'comment' => 'Can survive anything. Exceptional build quality and rugged engineering.'],
                ],
            ],

            // JEEPS
            [
                'category_id' => $jeeps->id,
                'user_id' => $dealer->id,
                'title' => 'Jeep Grand Cherokee L Summit 4x4',
                'brand' => 'Jeep',
                'model' => 'Grand Cherokee L',
                'year' => 2022,
                'price' => 58000.00,
                'mileage' => 31000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'color' => 'Midnight Black',
                'country' => 'UK',
                'description' => 'Three-row luxury with Palermo leather seats, McIntosh 19-speaker audiophile sound system, Quadra-Lift air suspension, and night vision camera.',
                'featured_image' => 'cars/5.jpg',
                'status' => 'available',
                'gallery' => ['cars/5.jpg', 'cars/6.jpg'],
                'reviews' => [
                    ['user_id' => $john->id, 'rating' => 5, 'comment' => 'The interior feels like an Italian private jet. Superb family SUV.'],
                ],
            ],
            [
                'category_id' => $jeeps->id,
                'user_id' => $admin->id,
                'title' => 'Jeep Grand Wagoneer L Obsidian Edition',
                'brand' => 'Jeep',
                'model' => 'Grand Wagoneer L',
                'year' => 2023,
                'price' => 98500.00,
                'mileage' => 11000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'color' => 'Bright White',
                'country' => 'Germany',
                'description' => 'Full-size flagship luxury SUV with twin-turbo Hurricane 510hp engine, 75 inches of total digital display screens, and massaging seats.',
                'featured_image' => 'cars/6.jpg',
                'status' => 'available',
                'gallery' => ['cars/6.jpg', 'cars/7.jpg'],
                'reviews' => [
                    ['user_id' => $elena->id, 'rating' => 5, 'comment' => 'Massive presence and ultra comfortable. The twin-turbo has endless power.'],
                ],
            ],
            [
                'category_id' => $jeeps->id,
                'user_id' => $elena->id,
                'title' => 'Jeep Renegade Trailhawk 4x4',
                'brand' => 'Jeep',
                'model' => 'Renegade',
                'year' => 2021,
                'price' => 28000.00,
                'mileage' => 42000,
                'transmission' => 'Automatic',
                'fuel_type' => 'Gasoline',
                'color' => 'Sting Gray',
                'country' => 'China',
                'description' => 'Compact Trail-Rated off-roader with Selec-Terrain rock crawl mode, red tow hooks, 8.4-inch Uconnect display, and open-air MySky roof panels.',
                'featured_image' => 'cars/7.jpg',
                'status' => 'available',
                'gallery' => ['cars/7.jpg', 'cars/5.jpg'],
                'reviews' => [
                    ['user_id' => $john->id, 'rating' => 4, 'comment' => 'Nimble in city traffic and surprisingly capable in mud and sand!'],
                ],
            ],
        ];

        foreach ($carsData as $data) {
            $gallery = $data['gallery'] ?? [];
            $reviews = $data['reviews'] ?? [];
            unset($data['gallery'], $data['reviews']);

            $car = Car::create($data);

            // Seed gallery images
            foreach ($gallery as $index => $imgPath) {
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $imgPath,
                    'is_primary' => ($index === 0),
                ]);
            }

            // Seed reviews
            foreach ($reviews as $rev) {
                Review::create([
                    'car_id' => $car->id,
                    'user_id' => $rev['user_id'],
                    'rating' => $rev['rating'],
                    'comment' => $rev['comment'],
                ]);
            }
        }
    }
}
