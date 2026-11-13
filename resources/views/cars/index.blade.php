@extends('layouts.app')

@section('title', __('market.nav_explore') . ' - ' . __('market.app_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- Hero Showcase Section -->
    <section class="relative rounded-3xl overflow-hidden glass-panel p-8 sm:p-12 lg:p-16 border border-white/15 shadow-2xl">
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-gradient-to-tr from-cyan-500/20 via-indigo-500/20 to-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-cyan-500/10 border border-cyan-500/30 text-cyan-300 text-xs font-semibold mb-6 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                {{ __('market.hero_badge') }}
            </div>

            <h1 class="text-4xl sm:text-6xl font-black tracking-tight text-white leading-tight">
                {{ __('market.hero_title_1') }} <br>
                <span class="bg-gradient-to-r from-cyan-400 via-sky-300 to-indigo-400 bg-clip-text text-transparent">
                    {{ __('market.hero_title_2') }}
                </span>
            </h1>

            <p class="mt-4 text-base sm:text-lg text-slate-300 max-w-2xl leading-relaxed">
                {{ __('market.hero_subtitle') }}
            </p>

            <div class="mt-8 flex flex-wrap items-center gap-4">
                <a href="#inventory" class="px-6 py-3.5 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-xl shadow-cyan-500/20 border border-white/20 transition-all hover:scale-105 active:scale-95">
                    {{ __('market.hero_cta_browse') }}
                </a>
                <a href="{{ route('cars.create') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm text-slate-200 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 backdrop-blur-md transition-all">
                    {{ __('market.hero_cta_sell') }}
                </a>
            </div>
        </div>
    </section>

    <!-- Category Filter Tabs: All, Sedans, Pickups, Jeeps -->
    <section id="inventory" class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-white tracking-tight">
                    {{ __('market.categories_title') }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-400">
                    {{ __('market.categories_subtitle') }}
                </p>
            </div>

            <span class="text-xs text-slate-400">
                Found <strong class="text-cyan-400 font-mono">{{ $cars->total() }}</strong> vehicles
            </span>
        </div>

        <!-- Filter Pills Bar -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
            <!-- ALL Category Pill -->
            <a href="{{ route('cars.index', array_merge(request()->except(['category', 'page']), ['category' => 'all'])) }}"
               class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all duration-200 border flex items-center gap-2 {{ ($selectedCategory === 'all' || !$selectedCategory) ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white border-cyan-400/50 shadow-lg shadow-cyan-500/25' : 'bg-white/5 text-slate-300 border-white/10 hover:bg-white/10' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span>{{ __('market.cat_all') }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ ($selectedCategory === 'all' || !$selectedCategory) ? 'bg-white/20 text-white' : 'bg-white/5 text-slate-400' }}">
                    {{ \App\Models\Car::count() }}
                </span>
            </a>

            <!-- Dynamic Category Pills (Sedans, Pickups, Jeeps) -->
            @foreach ($categories as $cat)
                @php
                    $isActive = ($selectedCategory === $cat->slug);
                    $iconSvg = match($cat->slug) {
                        'sedans' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>',
                        'pickups' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6H4a1 1 0 00-1 1v9h10zm0 0h6a1 1 0 001-1v-4a1 1 0 00-1-1h-6v6z"/>',
                        default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    };
                @endphp
                <a href="{{ route('cars.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold whitespace-nowrap transition-all duration-200 border flex items-center gap-2 {{ $isActive ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white border-cyan-400/50 shadow-lg shadow-cyan-500/25' : 'bg-white/5 text-slate-300 border-white/10 hover:bg-white/10' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $iconSvg !!}
                    </svg>
                    <span>{{ __('market.cat_' . $cat->slug) ?: $cat->name }}</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] {{ $isActive ? 'bg-white/20 text-white' : 'bg-white/5 text-slate-400' }}">
                        {{ $cat->cars_count }}
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Search & Advanced Filter Controls Bar -->
    <section class="glass-panel rounded-2xl p-4 sm:p-5 border border-white/10 shadow-lg">
        <form action="{{ route('cars.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3 items-center">
            
            <!-- Retain active category -->
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <!-- Search keywords -->
            <div class="lg:col-span-4 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="{{ __('market.search_placeholder') }}"
                       class="glass-input w-full pl-9 pr-3 py-2 text-xs rounded-xl placeholder-slate-500">
            </div>

            <!-- Min Price -->
            <div class="lg:col-span-2">
                <input type="number" 
                       name="min_price" 
                       value="{{ request('min_price') }}" 
                       placeholder="{{ __('market.filter_min_price') }}"
                       class="glass-input w-full px-3 py-2 text-xs rounded-xl placeholder-slate-500">
            </div>

            <!-- Max Price -->
            <div class="lg:col-span-2">
                <input type="number" 
                       name="max_price" 
                       value="{{ request('max_price') }}" 
                       placeholder="{{ __('market.filter_max_price') }}"
                       class="glass-input w-full px-3 py-2 text-xs rounded-xl placeholder-slate-500">
            </div>

            <!-- Sort By -->
            <div class="lg:col-span-2">
                <select name="sort" class="glass-input w-full px-3 py-2 text-xs rounded-xl bg-slate-900 text-slate-200">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>{{ __('market.sort_latest') }}</option>
                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>{{ __('market.sort_price_low') }}</option>
                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>{{ __('market.sort_price_high') }}</option>
                </select>
            </div>

            <!-- Actions (Filter & Reset) -->
            <div class="lg:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full py-2 px-3 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 border border-white/20 shadow-md shadow-cyan-500/20 transition-all text-center">
                    {{ __('market.search_button') }}
                </button>
                @if(request()->hasAny(['search', 'min_price', 'max_price', 'sort', 'category']))
                    <a href="{{ route('cars.index') }}" class="p-2 rounded-xl bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white border border-white/10 text-xs transition-all" title="{{ __('market.reset_filters') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                @endif
            </div>

        </form>
    </section>

    <!-- Cars Grid Section -->
    <section>
        @if ($cars->isEmpty())
            <div class="glass-panel rounded-3xl p-12 text-center border border-white/10">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/5 flex items-center justify-center text-slate-400 border border-white/10">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white">{{ __('market.no_cars_found') }}</h3>
                <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">{{ __('market.no_cars_sub') }}</p>
                <div class="mt-6">
                    <a href="{{ route('cars.index') }}" class="inline-flex px-5 py-2.5 rounded-xl text-xs font-semibold text-cyan-400 bg-cyan-500/10 border border-cyan-500/30 hover:bg-cyan-500/20 transition-all">
                        {{ __('market.reset_filters') }}
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach ($cars as $car)
                    <article class="glass-card rounded-3xl overflow-hidden flex flex-col group border border-white/10">
                        
                        <!-- Image Container with Badges -->
                        <div class="relative h-56 w-full overflow-hidden bg-slate-900">
                            <img src="{{ Str::startsWith($car->image_url, ['http://', 'https://']) ? $car->image_url : asset($car->image_url) }}"
                                alt="{{ $car->title }}"
                                loading="lazy"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">

                            <!-- Top Badges Overlay -->
                            <div class="absolute top-3 left-3 right-3 flex items-center justify-between pointer-events-none">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider backdrop-blur-md bg-slate-950/70 text-cyan-300 border border-white/15">
                                    {{ $car->category->name }}
                                </span>

                                <span class="px-3 py-1 rounded-full text-xs font-black font-mono tracking-tight backdrop-blur-md bg-emerald-950/80 text-emerald-300 border border-emerald-500/30 shadow-lg">
                                    ${{ number_format($car->price, 0, '.', ',') }}
                                </span>
                            </div>

                            <!-- Bottom Floating Rating Pill -->
                            <div class="absolute bottom-3 left-3 flex items-center gap-1.5 px-2.5 py-1 rounded-full backdrop-blur-md bg-black/60 text-amber-400 border border-white/10 text-xs">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-bold text-white text-[11px]">{{ number_format($car->averageRating(), 1) }}</span>
                                <span class="text-slate-400 text-[10px]">({{ $car->reviews->count() }})</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 sm:p-6 flex flex-col grow justify-between space-y-4">
                            
                            <div>
                                <div class="text-[11px] uppercase tracking-wider font-semibold text-cyan-400/90 mb-1">
                                    {{ $car->brand }} • {{ $car->year }}
                                </div>
                                <h3 class="text-lg font-bold text-white line-clamp-1 group-hover:text-cyan-300 transition-colors">
                                    <a href="{{ route('cars.show', $car) }}">{{ $car->title }}</a>
                                </h3>
                                @if($car->description)
                                    <p class="mt-1.5 text-xs text-slate-400 line-clamp-2 leading-relaxed">
                                        {{ $car->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Specs Chips Grid -->
                            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-300 pt-2 border-t border-white/5">
                                <div class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ number_format($car->mileage) }} km</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span>{{ $car->transmission }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    <span>{{ $car->fuel_type }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-400">
                                    <svg class="w-3.5 h-3.5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                                    <span class="truncate">{{ $car->country ?? 'Global' }}</span>
                                </div>
                            </div>

                            <!-- Footer Card Action -->
                            <div class="pt-3 border-t border-white/5 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center text-[10px] font-bold text-white uppercase">
                                        {{ substr($car->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <span class="text-xs text-slate-400 truncate max-w-[110px]">{{ $car->user->name ?? 'Dealer' }}</span>
                                </div>

                                <a href="{{ route('cars.show', $car) }}" 
                                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-cyan-300 hover:text-white bg-white/5 hover:bg-cyan-500/20 border border-white/10 hover:border-cyan-400/40 transition-all flex items-center gap-1">
                                    <span>{{ __('market.view_details') }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>

                        </div>

                    </article>
                @endforeach
            </div>

            <!-- Glass Pagination Links -->
            <div class="mt-8">
                {{ $cars->links() }}
            </div>
        @endif
    </section>

</div>
@endsection

