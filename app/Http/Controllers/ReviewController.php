<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Car;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new customer review for a vehicle.
     */
    public function store(StoreReviewRequest $request, Car $car): RedirectResponse
    {
        Review::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'rating' => $request->validated('rating'),
            'comment' => $request->validated('comment'),
        ]);

        return redirect()->route('cars.show', $car)
            ->with('success', __('market.review_created'));
    }

    /**
     * Remove the specified review.
     */
    public function destroy(Review $review): RedirectResponse
    {
        if ($review->user_id !== Auth::id() && ! Auth::user()->isAdmin()) {
            return back()->with('error', __('market.unauthorized_action'));
        }

        $car = $review->car;
        $review->delete();

        return redirect()->route('cars.show', $car)
            ->with('success', __('market.review_deleted'));
    }
}
