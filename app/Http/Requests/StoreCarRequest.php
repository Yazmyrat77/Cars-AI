<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:100'],
            'model' => ['required', 'string', 'max:100'],
            'category_id' => ['required', 'exists:categories,id'],
            'year' => ['required', 'integer', 'min:1950', 'max:'.(date('Y') + 2)],
            'price' => ['required', 'numeric', 'min:1'],
            'mileage' => ['nullable', 'integer', 'min:0'],
            'transmission' => ['required', 'in:Automatic,Manual'],
            'fuel_type' => ['required', 'in:Gasoline,Diesel,Hybrid,Electric'],
            'color' => ['required', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:5000'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery_images' => ['nullable', 'array'],
            'gallery_images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'status' => ['nullable', 'in:available,sold,reserved'],
        ];
    }
}
