<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'brand',
        'model',
        'year',
        'price',
        'mileage',
        'transmission',
        'fuel_type',
        'color',
        'country',
        'description',
        'featured_image',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'year' => 'integer',
            'mileage' => 'integer',
        ];
    }

    /**
     * Owner of the car listing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Vehicle category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Gallery images for the car.
     */
    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }

    /**
     * Reviews and ratings for the car.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->latest();
    }

    /**
     * Get resolved image path or fallback.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
                return $this->featured_image;
            }
            if (file_exists(public_path($this->featured_image))) {
                return asset($this->featured_image);
            }

            return asset('storage/'.ltrim($this->featured_image, '/'));
        }

        // Check if there is an image in gallery
        $firstGallery = $this->images->first();
        if ($firstGallery) {
            return $firstGallery->image_url;
        }

        return asset('cars/1.jpg');
    }

    /**
     * Calculate average rating.
     */
    public function averageRating(): float
    {
        return (float) ($this->reviews->avg('rating') ?? 5.0);
    }
}
