<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of vehicle categories.
     */
    public function index(): View
    {
        $categories = Category::withCount('cars')->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display cars belonging to a specific category.
     */
    public function show(Category $category): View
    {
        // Explicitly eager-load relationships with with() to avoid N+1 queries
        $cars = $category->cars()
            ->with(['category', 'user', 'images', 'reviews'])
            ->latest()
            ->paginate(9);

        return view('categories.show', compact('category', 'cars'));
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', __('market.category_created'));
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Safeguard default core categories
        if (in_array($category->slug, ['sedans', 'pickups', 'jeeps'], true)) {
            return back()->with('error', 'Default core categories cannot be deleted.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
