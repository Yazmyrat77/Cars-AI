@extends('layouts.app')

@section('title', __('market.edit_car_title') . ' - ' . __('market.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('cars.show', $car) }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-cyan-400 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('market.back_to_cars') }}
        </a>
        <h1 class="text-3xl font-black text-white tracking-tight sm:text-4xl">
            {{ __('market.edit_car_title') }}
        </h1>
        <p class="mt-1 text-sm text-slate-400">
            Updating: <strong class="text-cyan-300">{{ $car->title }}</strong>
        </p>
    </div>

    <!-- Form Panel -->
    <div class="glass-panel rounded-3xl p-6 sm:p-10 border border-white/15 shadow-2xl">
        <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Listing Title -->
            <div>
                <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    {{ __('market.field_title') }} *
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title', $car->title) }}" 
                       required 
                       class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('title') border-rose-500 @enderror">
                @error('title')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Brand, Model & Category Row (3 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="brand" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_brand') }} *
                    </label>
                    <input type="text" 
                           name="brand" 
                           id="brand" 
                           value="{{ old('brand', $car->brand) }}" 
                           required 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('brand') border-rose-500 @enderror">
                    @error('brand')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="model" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_model') }} *
                    </label>
                    <input type="text" 
                           name="model" 
                           id="model" 
                           value="{{ old('model', $car->model) }}" 
                           required 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('model') border-rose-500 @enderror">
                    @error('model')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_category') }} *
                    </label>
                    <select name="category_id" id="category_id" required class="glass-input w-full px-4 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $car->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Year, Price, Mileage & Status Row (4 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="year" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_year') }} *
                    </label>
                    <input type="number" 
                           name="year" 
                           id="year" 
                           min="1950" 
                           max="{{ date('Y') + 2 }}"
                           value="{{ old('year', $car->year) }}" 
                           required 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                </div>

                <div>
                    <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_price') }} *
                    </label>
                    <input type="number" 
                           step="0.01" 
                           name="price" 
                           id="price" 
                           value="{{ old('price', $car->price) }}" 
                           required 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                </div>

                <div>
                    <label for="mileage" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_mileage') }}
                    </label>
                    <input type="number" 
                           name="mileage" 
                           id="mileage" 
                           value="{{ old('mileage', $car->mileage) }}" 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                </div>

                <div>
                    <label for="status" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_status') }} *
                    </label>
                    <select name="status" id="status" class="glass-input w-full px-3 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        <option value="available" {{ old('status', $car->status) === 'available' ? 'selected' : '' }}>{{ __('market.status_available') }}</option>
                        <option value="sold" {{ old('status', $car->status) === 'sold' ? 'selected' : '' }}>{{ __('market.status_sold') }}</option>
                        <option value="reserved" {{ old('status', $car->status) === 'reserved' ? 'selected' : '' }}>{{ __('market.status_reserved') }}</option>
                    </select>
                </div>
            </div>

            <!-- Transmission, Fuel, Color & Country Row (4 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="transmission" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_transmission') }} *
                    </label>
                    <select name="transmission" id="transmission" class="glass-input w-full px-3 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        <option value="Automatic" {{ old('transmission', $car->transmission) === 'Automatic' ? 'selected' : '' }}>{{ __('market.trans_auto') }}</option>
                        <option value="Manual" {{ old('transmission', $car->transmission) === 'Manual' ? 'selected' : '' }}>{{ __('market.trans_manual') }}</option>
                    </select>
                </div>

                <div>
                    <label for="fuel_type" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_fuel_type') }} *
                    </label>
                    <select name="fuel_type" id="fuel_type" class="glass-input w-full px-3 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        <option value="Gasoline" {{ old('fuel_type', $car->fuel_type) === 'Gasoline' ? 'selected' : '' }}>{{ __('market.fuel_gasoline') }}</option>
                        <option value="Diesel" {{ old('fuel_type', $car->fuel_type) === 'Diesel' ? 'selected' : '' }}>{{ __('market.fuel_diesel') }}</option>
                        <option value="Hybrid" {{ old('fuel_type', $car->fuel_type) === 'Hybrid' ? 'selected' : '' }}>{{ __('market.fuel_hybrid') }}</option>
                        <option value="Electric" {{ old('fuel_type', $car->fuel_type) === 'Electric' ? 'selected' : '' }}>{{ __('market.fuel_electric') }}</option>
                    </select>
                </div>

                <div>
                    <label for="color" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_color') }} *
                    </label>
                    <input type="text" 
                           name="color" 
                           id="color" 
                           value="{{ old('color', $car->color) }}" 
                           required 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                </div>

                <div>
                    <label for="country" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_country') }}
                    </label>
                    <input type="text" 
                           name="country" 
                           id="country" 
                           value="{{ old('country', $car->country) }}" 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    {{ __('market.field_description') }}
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4" 
                          class="glass-input w-full px-4 py-3 rounded-xl text-sm">{{ old('description', $car->description) }}</textarea>
            </div>

            <!-- Current Featured Image Preview & Replacement -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-cyan-400">
                        {{ __('market.field_featured_image') }}
                    </label>
                    <div class="flex items-center gap-4">
                        <img src="{{ $car->image_url }}" alt="Current image" class="w-20 h-16 object-cover rounded-xl border border-white/10">
                        <div class="grow">
                            <input type="file" 
                                   name="featured_image" 
                                   accept="image/*"
                                   class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-cyan-500/20 file:text-cyan-300 hover:file:bg-cyan-500/30">
                            <p class="text-[10px] text-slate-500 mt-1">Leave empty to keep current photo.</p>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-indigo-400">
                        {{ __('market.field_gallery_images') }}
                    </label>
                    <input type="file" 
                           name="gallery_images[]" 
                           multiple 
                           accept="image/*"
                           class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-500/20 file:text-indigo-300 hover:file:bg-indigo-500/30">
                    <p class="text-[10px] text-slate-500">Upload additional gallery photos.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-white/10 flex items-center justify-end gap-3">
                <a href="{{ route('cars.show', $car) }}" class="px-5 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 transition-all">
                    {{ __('market.cancel') }}
                </a>
                <button type="submit" class="px-7 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-xl shadow-cyan-500/20 border border-white/20 transition-all">
                    {{ __('market.update_car') }}
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

