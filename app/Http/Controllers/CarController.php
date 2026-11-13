<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CarController extends Controller
{
    /**
     * Display a listing of vehicles with search and category filtering.
     */
    public function index(Request $request): View
    {
        $selectedCategory = $request->query('category', 'all');
        $search = $request->query('search');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $year = $request->query('year');
        $sort = $request->query('sort', 'latest');

        // Eager load relationships explicitly with with() to prevent N+1 queries
        $query = Car::with(['category', 'user', 'images', 'reviews']);

        // Filter by category
        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('category', function ($q) use ($selectedCategory) {
                $q->where('slug', $selectedCategory);
            });
        }

        // Search by title, brand, model, or country
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%");
            });
        }

        // Additional price / year filters
        if ($minPrice) {
            $query->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', (float) $maxPrice);
        }
        if ($year) {
            $query->where('year', (int) $year);
        }

        // Sorting
        match ($sort) {
            'price_low' => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'year' => $query->orderBy('year', 'desc'),
            default => $query->latest(),
        };

        $cars = $query->paginate(9)->withQueryString();
        $categories = Category::withCount('cars')->get();

        return view('cars.index', compact('cars', 'categories', 'selectedCategory', 'search'));
    }

    /**
     * Show the form for creating a new vehicle listing.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('cars.create', compact('categories'));
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(StoreCarRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        // Handle primary featured image
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('cars', 'public');
            $validated['featured_image'] = $path;
        } else {
            $validated['featured_image'] = 'cars/1.jpg';
        }

        $car = Car::create($validated);

        // Handle additional gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $imageFile) {
                $imagePath = $imageFile->store('cars', 'public');
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $imagePath,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('cars.show', $car)
            ->with('success', __('market.car_created'));
    }

    /**
     * Display the specified vehicle with eager-loaded relations.
     */
    public function show(Car $car): View
    {
        // Explicit eager loading with with()
        $car->load(['category', 'user', 'images', 'reviews.user']);

        $relatedCars = Car::with(['category', 'user', 'images'])
            ->where('category_id', $car->category_id)
            ->where('id', '!=', $car->id)
            ->take(3)
            ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Car $car): View|RedirectResponse
    {
        if ($car->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            return redirect()->route('cars.show', $car)
                ->with('error', __('market.unauthorized_action'));
        }

        $categories = Category::orderBy('name')->get();

        return view('cars.edit', compact('car', 'categories'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(UpdateCarRequest $request, Car $car): RedirectResponse
    {
        if ($car->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            return redirect()->route('cars.show', $car)
                ->with('error', __('market.unauthorized_action'));
        }

        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($car->featured_image && Storage::disk('public')->exists($car->featured_image)) {
                Storage::disk('public')->delete($car->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('cars', 'public');
        }

        $car->update($validated);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $imageFile) {
                $imagePath = $imageFile->store('cars', 'public');
                CarImage::create([
                    'car_id' => $car->id,
                    'image_path' => $imagePath,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('cars.show', $car)
            ->with('success', __('market.car_updated'));
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Car $car): RedirectResponse
    {
        if ($car->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            return redirect()->route('cars.show', $car)
                ->with('error', __('market.unauthorized_action'));
        }

        // Clean up stored images
        if ($car->featured_image && Storage::disk('public')->exists($car->featured_image)) {
            Storage::disk('public')->delete($car->featured_image);
        }

        foreach ($car->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $car->delete();

        return redirect()->route('cars.index')
            ->with('success', __('market.car_deleted'));
    }
}
