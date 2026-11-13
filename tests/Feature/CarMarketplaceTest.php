<?php

use App\Models\Car;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;

test('authenticated user can view cars index with categories and filter by category', function () {
    $user = User::factory()->create();
    $sedans = Category::firstOrCreate(['slug' => 'sedans'], ['name' => 'Sedans']);
    $pickups = Category::firstOrCreate(['slug' => 'pickups'], ['name' => 'Pickups']);

    $sedanCar = Car::factory()->create([
        'category_id' => $sedans->id,
        'title' => 'Luxury Sedan Camry',
    ]);
    $pickupCar = Car::factory()->create([
        'category_id' => $pickups->id,
        'title' => 'Heavy Duty F-150',
    ]);

    // Test All categories
    $responseAll = $this->actingAs($user)->get(route('cars.index'));
    $responseAll->assertStatus(200);
    $responseAll->assertSee('Luxury Sedan Camry');
    $responseAll->assertSee('Heavy Duty F-150');

    // Test Sedans filter
    $responseSedans = $this->actingAs($user)->get(route('cars.index', ['category' => 'sedans']));
    $responseSedans->assertStatus(200);
    $responseSedans->assertSee('Luxury Sedan Camry');
    $responseSedans->assertDontSee('Heavy Duty F-150');
});

test('authenticated user can create a vehicle listing', function () {
    $user = User::factory()->create();
    $category = Category::firstOrCreate(['slug' => 'sedans'], ['name' => 'Sedans']);

    $response = $this->actingAs($user)->post(route('cars.store'), [
        'title' => '2024 Honda Accord Sport',
        'brand' => 'Honda',
        'model' => 'Accord',
        'category_id' => $category->id,
        'year' => 2024,
        'price' => 32000,
        'mileage' => 5000,
        'transmission' => 'Automatic',
        'fuel_type' => 'Hybrid',
        'color' => 'Sonic Gray',
        'country' => 'Japan',
        'description' => 'Mint condition sport sedan.',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('cars', [
        'title' => '2024 Honda Accord Sport',
        'user_id' => $user->id,
    ]);
});

test('user can submit review for a vehicle and delete own review', function () {
    $user = User::factory()->create();
    $car = Car::first() ?? Car::factory()->create();

    $response = $this->actingAs($user)->post(route('reviews.store', $car), [
        'rating' => 5,
        'comment' => 'Exceptional vehicle, smooth and quiet ride!',
    ]);

    $response->assertSessionHas('success');
    $review = Review::where('car_id', $car->id)->where('user_id', $user->id)->first();
    expect($review)->not->toBeNull();
    expect($review->comment)->toBe('Exceptional vehicle, smooth and quiet ride!');

    // Delete review
    $deleteResponse = $this->actingAs($user)->delete(route('reviews.destroy', $review));
    $deleteResponse->assertSessionHas('success');
    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});

