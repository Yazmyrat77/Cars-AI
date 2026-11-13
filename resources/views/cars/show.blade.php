@extends('layouts.app')

@section('title', $car->title . ' - ' . __('market.app_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- Back Navigation Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('cars.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            {{ __('market.back_to_cars') }}
        </a>

        <!-- Owner / Admin Controls -->
        @if (Auth::check() && ($car->user_id === Auth::id() || Auth::user()->isAdmin()))
            <div class="flex items-center gap-2">
                <a href="{{ route('cars.edit', $car) }}" 
                   class="px-4 py-2 rounded-xl text-xs font-bold text-slate-200 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    <span>{{ __('market.edit_car') }}</span>
                </a>

                <form action="{{ route('cars.destroy', $car) }}" method="POST" onsubmit="return confirm('{{ __('market.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 rounded-xl text-xs font-bold text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 transition-all flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        <span>{{ __('market.delete_car') }}</span>
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Main Detail Showcase Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Gallery & Description (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Primary Gallery Display -->
            <div class="glass-panel rounded-3xl p-3 border border-white/15 overflow-hidden">
                <div class="relative h-80 sm:h-96 md:h-[28rem] rounded-2xl overflow-hidden bg-slate-900">
                    <img id="mainVehicleImage" 
                         src="{{ $car->image_url }}" 
                         alt="{{ $car->title }}" 
                         class="w-full h-full object-cover transition-all duration-300">
                    
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider backdrop-blur-md bg-slate-950/70 text-cyan-300 border border-white/15">
                            {{ $car->category->name }}
                        </span>
                        <span class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider backdrop-blur-md bg-black/60 text-emerald-400 border border-emerald-500/30">
                            {{ ucfirst($car->status) }}
                        </span>
                    </div>
                </div>

                <!-- Gallery Thumbnails -->
                @if ($car->images->isNotEmpty())
                    <div class="flex items-center gap-3 mt-3 p-1 overflow-x-auto">
                        <!-- Primary Image Thumbnail -->
                        <button type="button" 
                                onclick="changeMainImage('{{ $car->image_url }}')"
                                class="w-20 h-16 rounded-xl overflow-hidden shrink-0 border-2 border-cyan-400 focus:outline-none transition-all hover:opacity-90">
                            <img src="{{ $car->image_url }}" class="w-full h-full object-cover" alt="Thumb">
                        </button>
                        
                        <!-- Additional Images -->
                        @foreach ($car->images as $img)
                            <button type="button" 
                                    onclick="changeMainImage('{{ $img->image_url }}')"
                                    class="w-20 h-16 rounded-xl overflow-hidden shrink-0 border border-white/20 focus:border-cyan-400 focus:outline-none transition-all hover:opacity-90">
                                <img src="{{ $img->image_url }}" class="w-full h-full object-cover" alt="Gallery">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Description Card -->
            <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10 space-y-4">
                <h3 class="text-xl font-bold text-white tracking-tight flex items-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    <span>{{ __('market.field_description') }}</span>
                </h3>
                <p class="text-slate-300 text-sm leading-relaxed whitespace-pre-line">
                    {{ $car->description ?? 'No specific detailed description provided by the seller.' }}
                </p>
            </div>

        </div>

        <!-- Right Column: Specs, Price & Seller Contact (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Price & Title Card -->
            <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/15 space-y-5">
                <div>
                    <div class="text-xs uppercase font-semibold tracking-wider text-cyan-400 mb-1">
                        {{ $car->brand }} • {{ $car->year }}
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                        {{ $car->title }}
                    </h1>
                </div>

                <div class="flex items-baseline justify-between pt-4 border-t border-white/10">
                    <div>
                        <div class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Price</div>
                        <div class="text-3xl sm:text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400 font-mono">
                            ${{ number_format($car->price, 0, '.', ',') }}
                        </div>
                    </div>

                    <!-- Average Rating -->
                    <div class="text-right">
                        <div class="flex items-center gap-1 text-amber-400 justify-end">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <span class="text-lg font-bold text-white">{{ number_format($car->averageRating(), 1) }}</span>
                        </div>
                        <span class="text-xs text-slate-400">{{ $car->reviews->count() }} {{ __('market.reviews_title') }}</span>
                    </div>
                </div>

                <!-- Technical Specs Grid -->
                <div class="pt-4 border-t border-white/10 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">
                        {{ __('market.specifications') }}
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5">
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ __('market.spec_year') }}</div>
                            <div class="text-sm font-bold text-white mt-0.5">{{ $car->year }}</div>
                        </div>

                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5">
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ __('market.spec_mileage') }}</div>
                            <div class="text-sm font-bold text-white mt-0.5">{{ number_format($car->mileage) }} km</div>
                        </div>

                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5">
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ __('market.spec_transmission') }}</div>
                            <div class="text-sm font-bold text-white mt-0.5">{{ $car->transmission }}</div>
                        </div>

                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5">
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ __('market.spec_fuel') }}</div>
                            <div class="text-sm font-bold text-white mt-0.5">{{ $car->fuel_type }}</div>
                        </div>

                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5">
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ __('market.spec_color') }}</div>
                            <div class="text-sm font-bold text-white mt-0.5">{{ $car->color }}</div>
                        </div>

                        <div class="p-3 rounded-2xl bg-white/5 border border-white/5">
                            <div class="text-[10px] text-slate-400 uppercase font-semibold">{{ __('market.spec_country') }}</div>
                            <div class="text-sm font-bold text-white mt-0.5 truncate">{{ $car->country ?? 'Global' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Seller Info Card -->
                <div class="pt-5 border-t border-white/10 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center font-bold text-white text-lg shadow-lg">
                            {{ substr($car->user->name ?? 'D', 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $car->user->name ?? 'Automarket Dealer' }}</div>
                            <div class="text-[11px] text-cyan-400 font-mono">{{ $car->user->email ?? 'verified@automarket.com' }}</div>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-cyan-500/10 text-cyan-300 border border-cyan-500/30">
                        {{ __('market.verified_seller') }}
                    </span>
                </div>

                <!-- Contact CTA Button -->
                <a href="mailto:{{ $car->user->email }}?subject=Inquiry about {{ urlencode($car->title) }}" 
                   class="w-full py-3.5 px-4 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-xl shadow-cyan-500/20 border border-white/20 transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ __('market.contact_seller') }}</span>
                </a>

            </div>

        </div>

    </div>

    <!-- Community Reviews Section -->
    <section class="glass-panel rounded-3xl p-6 sm:p-10 border border-white/15 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <h3 class="text-2xl font-black text-white tracking-tight flex items-center gap-3">
                    <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span>{{ __('market.reviews_title') }}</span>
                </h3>
                <p class="text-xs text-slate-400 mt-1">Verified buyer and enthusiast impressions for this vehicle</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-3xl font-black text-white font-mono">{{ number_format($car->averageRating(), 1) }}</span>
                <div class="text-xs text-slate-400">
                    <div class="text-amber-400 font-bold">★★★★★</div>
                    <div>{{ $car->reviews->count() }} ratings</div>
                </div>
            </div>
        </div>

        <!-- Submit Review Form -->
        @auth
            <form action="{{ route('reviews.store', $car) }}" method="POST" class="p-6 rounded-2xl bg-white/5 border border-white/10 space-y-4">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <h4 class="text-sm font-bold text-white">{{ __('market.leave_review') }}</h4>
                    
                    <!-- Rating Select -->
                    <div class="flex items-center gap-2">
                        <label for="rating" class="text-xs text-slate-300 font-semibold">{{ __('market.review_rating') }}:</label>
                        <select name="rating" id="rating" class="glass-input px-3 py-1 text-xs rounded-xl bg-slate-900 text-amber-300 font-bold">
                            <option value="5">★★★★★ (5/5)</option>
                            <option value="4">★★★★☆ (4/5)</option>
                            <option value="3">★★★☆☆ (3/5)</option>
                            <option value="2">★★☆☆☆ (2/5)</option>
                            <option value="1">★☆☆☆☆ (1/5)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <textarea name="comment" 
                              rows="3" 
                              required 
                              placeholder="{{ __('market.review_comment') }}"
                              class="glass-input w-full p-3 rounded-xl text-xs placeholder-slate-500 @error('comment') border-rose-500 @enderror"></textarea>
                    @error('comment')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 border border-white/20 shadow-md">
                        {{ __('market.submit_review') }}
                    </button>
                </div>
            </form>
        @else
            <div class="p-4 rounded-xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-200 text-xs text-center">
                Please <a href="{{ route('login') }}" class="font-bold underline text-white">Sign In</a> to write a review.
            </div>
        @endauth

        <!-- Reviews List -->
        @if ($car->reviews->isEmpty())
            <div class="text-center py-6 text-slate-400 text-xs">
                {{ __('market.no_reviews_yet') }}
            </div>
        @else
            <div class="space-y-4">
                @foreach ($car->reviews as $rev)
                    <div class="p-5 rounded-2xl bg-white/5 border border-white/10 space-y-2 relative group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center text-xs font-bold text-white uppercase">
                                    {{ substr($rev->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-white">{{ $rev->user->name ?? 'Community Member' }}</span>
                                    <span class="text-[10px] text-slate-400 ml-2 font-mono">{{ $rev->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="text-amber-400 text-xs font-bold tracking-widest">
                                    {{ str_repeat('★', $rev->rating) . str_repeat('☆', 5 - $rev->rating) }}
                                </div>

                                <!-- Delete Review Action -->
                                @if (Auth::check() && ($rev->user_id === Auth::id() || Auth::user()->isAdmin()))
                                    <form action="{{ route('reviews.destroy', $rev) }}" method="POST" onsubmit="return confirm('{{ __('market.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-500 hover:text-rose-400 transition-colors p-1" title="{{ __('market.delete_review') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <p class="text-xs text-slate-300 leading-relaxed pl-11">
                            {{ $rev->comment }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif

    </section>

    <!-- Related Vehicles Section -->
    @if ($relatedCars->isNotEmpty())
        <section class="space-y-4">
            <h3 class="text-xl font-black text-white tracking-tight">More in {{ $car->category->name }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($relatedCars as $rel)
                    <div class="glass-card rounded-2xl overflow-hidden p-4 border border-white/10 flex flex-col justify-between space-y-3">
                        <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-40 object-cover rounded-xl">
                        <div>
                            <div class="text-[10px] text-cyan-400 font-bold uppercase">{{ $rel->brand }} • {{ $rel->year }}</div>
                            <h4 class="text-sm font-bold text-white line-clamp-1">{{ $rel->title }}</h4>
                            <div class="text-sm font-black text-emerald-400 font-mono mt-1">${{ number_format($rel->price) }}</div>
                        </div>
                        <a href="{{ route('cars.show', $rel) }}" class="text-xs font-bold text-cyan-300 hover:text-white transition-colors flex items-center gap-1">
                            <span>{{ __('market.view_details') }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

</div>

@push('scripts')
<script>
    function changeMainImage(src) {
        const main = document.getElementById('mainVehicleImage');
        if (main) {
            main.style.opacity = '0';
            setTimeout(() => {
                main.src = src;
                main.style.opacity = '1';
            }, 150);
        }
    }
</script>
@endpush
@endsection

