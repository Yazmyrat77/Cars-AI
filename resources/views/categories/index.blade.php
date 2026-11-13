@extends('layouts.app')

@section('title', __('market.categories_title') . ' - ' . __('market.app_name'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                {{ __('market.categories_title') }}
            </h1>
            <p class="mt-1 text-sm text-slate-400">
                {{ __('market.categories_subtitle') }}
            </p>
        </div>

        <a href="{{ route('cars.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-200 bg-white/5 hover:bg-white/10 border border-white/10 transition-all self-start sm:self-auto">
            <span>{{ __('market.cat_all') }}</span>
            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>

    <!-- Category Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach ($categories as $cat)
            @php
                $bgGradient = match($cat->slug) {
                    'sedans' => 'from-blue-600/20 to-cyan-600/20',
                    'pickups' => 'from-amber-600/20 to-orange-600/20',
                    default => 'from-emerald-600/20 to-teal-600/20',
                };
                $iconSvg = match($cat->slug) {
                    'sedans' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>',
                    'pickups' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6H4a1 1 0 00-1 1v9h10zm0 0h6a1 1 0 001-1v-4a1 1 0 00-1-1h-6v6z"/>',
                    default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                };
            @endphp
            <div class="glass-card rounded-3xl p-8 border border-white/10 flex flex-col justify-between space-y-6 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-44 h-44 bg-gradient-to-tr {{ $bgGradient }} rounded-full blur-2xl group-hover:scale-125 transition-transform duration-500"></div>

                <div class="space-y-4 relative z-10">
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $iconSvg !!}
                            </svg>
                        </div>
                        <span class="px-3.5 py-1 rounded-full text-xs font-bold font-mono bg-white/5 text-cyan-300 border border-white/10">
                            {{ $cat->cars_count }} vehicles
                        </span>
                    </div>

                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tight group-hover:text-cyan-300 transition-colors">
                            {{ $cat->name }}
                        </h2>
                        <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                            {{ __('market.category_desc_' . $cat->slug) ?: $cat->description }}
                        </p>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/5 relative z-10">
                    <a href="{{ route('cars.index', ['category' => $cat->slug]) }}" 
                       class="w-full py-3 px-4 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-white/5 hover:bg-cyan-500/20 border border-white/10 hover:border-cyan-400/40 transition-all flex items-center justify-center gap-2">
                        <span>Browse {{ $cat->name }}</span>
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Create Category Form (Admin / Authenticated) -->
    @if (Auth::check() && Auth::user()->isAdmin())
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/15 max-w-xl">
            <h3 class="text-lg font-bold text-white mb-4">Add Custom Category (Admin)</h3>
            <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-300 mb-1">Category Name</label>
                    <input type="text" name="name" required placeholder="e.g. Electric & Hybrid" class="glass-input w-full px-4 py-2.5 rounded-xl text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-300 mb-1">Description</label>
                    <input type="text" name="description" placeholder="Brief summary of vehicle category..." class="glass-input w-full px-4 py-2.5 rounded-xl text-xs">
                </div>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 border border-white/20">
                    Create Category
                </button>
            </form>
        </div>
    @endif

</div>
@endsection

