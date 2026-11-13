@extends('layouts.app')

@section('title', $category->name . ' - ' . __('market.app_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">

    <!-- Header -->
    <div class="glass-panel rounded-3xl p-8 sm:p-12 border border-white/15 relative overflow-hidden">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-400 hover:text-cyan-400 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            All Categories
        </a>
        <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
            {{ $category->name }}
        </h1>
        <p class="mt-2 text-sm text-slate-300 max-w-2xl leading-relaxed">
            {{ __('market.category_desc_' . $category->slug) ?: $category->description }}
        </p>
    </div>

    <!-- Vehicles List -->
    @if ($cars->isEmpty())
        <div class="glass-panel rounded-3xl p-12 text-center border border-white/10">
            <p class="text-sm text-slate-400">No vehicles listed under this category yet.</p>
            <div class="mt-4">
                <a href="{{ route('cars.create') }}" class="inline-flex px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-cyan-500 to-indigo-600">
                    {{ __('market.nav_post_car') }}
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @foreach ($cars as $car)
                <article class="glass-card rounded-3xl overflow-hidden flex flex-col group border border-white/10">
                    <div class="relative h-56 w-full overflow-hidden bg-slate-900">
                        <img src="{{ $car->image_url }}" alt="{{ $car->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase backdrop-blur-md bg-slate-950/70 text-cyan-300 border border-white/15">
                                {{ $car->category->name }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-black font-mono backdrop-blur-md bg-emerald-950/80 text-emerald-300 border border-emerald-500/30">
                                ${{ number_format($car->price, 0, '.', ',') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5 sm:p-6 flex flex-col grow justify-between space-y-4">
                        <div>
                            <div class="text-[11px] uppercase font-semibold text-cyan-400/90 mb-1">
                                {{ $car->brand }} • {{ $car->year }}
                            </div>
                            <h3 class="text-lg font-bold text-white line-clamp-1">
                                <a href="{{ route('cars.show', $car) }}">{{ $car->title }}</a>
                            </h3>
                        </div>

                        <div class="pt-3 border-t border-white/5 flex items-center justify-between">
                            <span class="text-xs text-slate-400">{{ number_format($car->mileage) }} km</span>
                            <a href="{{ route('cars.show', $car) }}" class="px-3.5 py-1.5 rounded-xl text-xs font-bold text-cyan-300 hover:text-white bg-white/5 hover:bg-cyan-500/20 border border-white/10 transition-all flex items-center gap-1">
                                <span>{{ __('market.view_details') }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $cars->links() }}
        </div>
    @endif

</div>
@endsection

