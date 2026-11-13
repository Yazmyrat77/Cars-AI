@extends('layouts.app')

@section('title', __('market.create_car_title') . ' - ' . __('market.app_name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('cars.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-cyan-400 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('market.back_to_cars') }}
        </a>
        <h1 class="text-3xl font-black text-white tracking-tight sm:text-4xl">
            {{ __('market.create_car_title') }}
        </h1>
        <p class="mt-1 text-sm text-slate-400">
            {{ __('market.create_car_subtitle') }}
        </p>
    </div>

    <!-- Form Panel -->
    <div class="glass-panel rounded-3xl p-6 sm:p-10 border border-white/15 shadow-2xl">
        <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Listing Title -->
            <div>
                <label for="title" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                    {{ __('market.field_title') }} *
                </label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title') }}" 
                       required 
                       placeholder="{{ __('market.field_title_placeholder') }}"
                       class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('title') border-rose-500 @enderror">
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
                           value="{{ old('brand') }}" 
                           required 
                           placeholder="e.g. Toyota"
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('brand') border-rose-500 @enderror">
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
                           value="{{ old('model') }}" 
                           required 
                           placeholder="e.g. Camry"
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('model') border-rose-500 @enderror">
                    @error('model')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_category') }} *
                    </label>
                    <select name="category_id" id="category_id" required class="glass-input w-full px-4 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        <option value="">{{ __('market.field_select_category') }}</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Year, Price & Mileage Row (3 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="year" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_year') }} *
                    </label>
                    <input type="number" 
                           name="year" 
                           id="year" 
                           min="1950" 
                           max="{{ date('Y') + 2 }}"
                           value="{{ old('year', date('Y')) }}" 
                           required 
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('year') border-rose-500 @enderror">
                    @error('year')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_price') }} *
                    </label>
                    <input type="number" 
                           step="0.01" 
                           name="price" 
                           id="price" 
                           value="{{ old('price') }}" 
                           required 
                           placeholder="45000"
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('price') border-rose-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mileage" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_mileage') }}
                    </label>
                    <input type="number" 
                           name="mileage" 
                           id="mileage" 
                           value="{{ old('mileage', 0) }}" 
                           placeholder="15000"
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('mileage') border-rose-500 @enderror">
                    @error('mileage')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Transmission, Fuel, Color & Country Row (4 cols) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="transmission" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_transmission') }} *
                    </label>
                    <select name="transmission" id="transmission" class="glass-input w-full px-3 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        <option value="Automatic" {{ old('transmission') === 'Automatic' ? 'selected' : '' }}>{{ __('market.trans_auto') }}</option>
                        <option value="Manual" {{ old('transmission') === 'Manual' ? 'selected' : '' }}>{{ __('market.trans_manual') }}</option>
                    </select>
                </div>

                <div>
                    <label for="fuel_type" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_fuel_type') }} *
                    </label>
                    <select name="fuel_type" id="fuel_type" class="glass-input w-full px-3 py-3 rounded-xl text-sm bg-slate-900 text-slate-200">
                        <option value="Gasoline" {{ old('fuel_type') === 'Gasoline' ? 'selected' : '' }}>{{ __('market.fuel_gasoline') }}</option>
                        <option value="Diesel" {{ old('fuel_type') === 'Diesel' ? 'selected' : '' }}>{{ __('market.fuel_diesel') }}</option>
                        <option value="Hybrid" {{ old('fuel_type') === 'Hybrid' ? 'selected' : '' }}>{{ __('market.fuel_hybrid') }}</option>
                        <option value="Electric" {{ old('fuel_type') === 'Electric' ? 'selected' : '' }}>{{ __('market.fuel_electric') }}</option>
                    </select>
                </div>

                <div>
                    <label for="color" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_color') }} *
                    </label>
                    <input type="text" 
                           name="color" 
                           id="color" 
                           value="{{ old('color') }}" 
                           required 
                           placeholder="e.g. Midnight Black"
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('color') border-rose-500 @enderror">
                    @error('color')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="country" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_country') }}
                    </label>
                    <input type="text" 
                           name="country" 
                           id="country" 
                           value="{{ old('country') }}" 
                           placeholder="e.g. Germany"
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
                          placeholder="Provide detailed maintenance records, trim packages, condition, and warranty status..."
                          class="glass-input w-full px-4 py-3 rounded-xl text-sm @error('description') border-rose-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Uploads -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-cyan-400">
                        {{ __('market.field_featured_image') }}
                    </label>
                    <input type="file" 
                           name="featured_image" 
                           accept="image/*"
                           class="block w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-cyan-500/20 file:text-cyan-300 hover:file:bg-cyan-500/30">
                    <p class="text-[11px] text-slate-500">{{ __('market.field_featured_image_hint') }}</p>
                    @error('featured_image')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
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
                    <p class="text-[11px] text-slate-500">Select multiple photos for interior, angles, etc.</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-6 border-t border-white/10 flex items-center justify-end gap-3">
                <a href="{{ route('cars.index') }}" class="px-5 py-3 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-white/5 hover:bg-white/10 transition-all">
                    {{ __('market.cancel') }}
                </a>
                <button type="submit" class="px-7 py-3.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-xl shadow-cyan-500/20 border border-white/20 transition-all">
                    {{ __('market.save_car') }}
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

