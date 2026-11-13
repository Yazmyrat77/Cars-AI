<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('market.app_name') . ' - ' . __('market.app_tagline'))</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen relative overflow-x-hidden selection:bg-cyan-500 selection:text-white flex flex-col font-sans">

    <!-- Ambient Glowing Gradient Orbs for Glassmorphism Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/4 -right-40 w-[30rem] h-[30rem] bg-indigo-600/15 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 left-1/3 w-[36rem] h-[36rem] bg-purple-600/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(#ffffff08_1px,transparent_1px)] [background-size:24px_24px]"></div>
    </div>

    <!-- Glassmorphism Navbar -->
    <header class="sticky top-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('cars.index') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-cyan-500/25 group-hover:scale-105 transition-transform duration-300 border border-white/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight bg-gradient-to-r from-white via-slate-100 to-cyan-400 bg-clip-text text-transparent">
                                Auto<span class="text-cyan-400">Market</span>
                            </span>
                            <span class="hidden sm:block text-[10px] uppercase tracking-widest text-cyan-400/80 font-semibold">Glass Edition</span>
                        </div>
                    </a>

                    <!-- Navigation Links -->
                    @auth
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('cars.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('cars.index') ? 'text-cyan-400 bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            {{ __('market.nav_explore') }}
                        </a>
                        <a href="{{ route('categories.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('categories.*') ? 'text-cyan-400 bg-white/10 shadow-sm border border-white/10' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            {{ __('market.nav_categories') }}
                        </a>
                    </nav>
                    @endauth
                </div>

                <!-- Right Side: Language Switcher & User Menu -->
                <div class="flex items-center gap-3 sm:gap-4">
                    
                    <!-- Language Switcher Pills -->
                    <div class="flex items-center bg-slate-900/60 p-1 rounded-xl border border-white/10 backdrop-blur-md">
                        <a href="{{ route('lang.switch', 'en') }}" 
                           class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all {{ app()->getLocale() === 'en' ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200' }}"
                           title="English">
                            EN
                        </a>
                        <a href="{{ route('lang.switch', 'ru') }}" 
                           class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all {{ app()->getLocale() === 'ru' ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200' }}"
                           title="Русский">
                            RU
                        </a>
                        <a href="{{ route('lang.switch', 'tk') }}" 
                           class="px-2.5 py-1 text-xs font-semibold rounded-lg transition-all {{ app()->getLocale() === 'tk' ? 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-sm' : 'text-slate-400 hover:text-slate-200' }}"
                           title="Türkmençe">
                            TK
                        </a>
                    </div>

                    <!-- Auth State Controls -->
                    @auth
                        <!-- Post Car CTA -->
                        <a href="{{ route('cars.create') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 text-white shadow-lg shadow-cyan-500/20 border border-white/20 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('market.nav_post_car') }}
                        </a>

                        <!-- User Info & Logout Dropdown / Button -->
                        <div class="flex items-center gap-3 pl-2 sm:border-l sm:border-white/10">
                            <div class="hidden lg:flex flex-col text-right">
                                <span class="text-sm font-semibold text-slate-200 leading-tight">{{ Auth::user()->name }}</span>
                                <span class="text-[11px] text-cyan-400 font-mono">{{ '@' . (Auth::user()->username ?? 'user') }}</span>
                            </div>
                            
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="p-2.5 rounded-xl bg-white/5 hover:bg-rose-500/20 text-slate-300 hover:text-rose-300 border border-white/10 hover:border-rose-500/30 transition-all duration-200 shadow-sm"
                                        title="{{ __('market.nav_logout') }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-200 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-all">
                                {{ __('market.nav_login') }}
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-cyan-500 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-md shadow-cyan-500/20 border border-white/20 transition-all">
                                {{ __('market.nav_register') }}
                            </a>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </header>

    <!-- Global Toast / Alert Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
        @if (session('success'))
            <div class="mb-4 p-4 rounded-2xl glass-panel border border-emerald-500/30 bg-emerald-950/40 text-emerald-200 flex items-center justify-between gap-3 shadow-lg shadow-emerald-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/20 flex items-center justify-center shrink-0 border border-emerald-500/40">
                        <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400/60 hover:text-emerald-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-4 p-4 rounded-2xl glass-panel border border-amber-500/40 bg-amber-950/40 text-amber-200 flex items-center justify-between gap-3 shadow-lg shadow-amber-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-amber-500/20 flex items-center justify-center shrink-0 border border-amber-500/40">
                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('warning') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-amber-400/60 hover:text-amber-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 rounded-2xl glass-panel border border-rose-500/40 bg-rose-950/40 text-rose-200 flex items-center justify-between gap-3 shadow-lg shadow-rose-900/20">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-rose-500/20 flex items-center justify-center shrink-0 border border-rose-500/40">
                        <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-400/60 hover:text-rose-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="grow">
        @yield('content')
    </main>

    <!-- Glassmorphism Footer -->
    <footer class="mt-20 border-t border-white/10 glass-nav py-12 text-slate-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center text-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-black text-white">Auto<span class="text-cyan-400">Market</span></span>
                    </div>
                    <p class="text-slate-400 max-w-md text-xs sm:text-sm leading-relaxed">
                        {{ __('market.footer_about') }}
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-3">{{ __('market.categories_title') }}</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('cars.index', ['category' => 'sedans']) }}" class="hover:text-cyan-400 transition-colors">{{ __('market.cat_sedans') }}</a></li>
                        <li><a href="{{ route('cars.index', ['category' => 'pickups']) }}" class="hover:text-cyan-400 transition-colors">{{ __('market.cat_pickups') }}</a></li>
                        <li><a href="{{ route('cars.index', ['category' => 'jeeps']) }}" class="hover:text-cyan-400 transition-colors">{{ __('market.cat_jeeps') }}</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-3">{{ __('market.language') }}</h4>
                    <div class="flex flex-col gap-1.5 text-xs">
                        <a href="{{ route('lang.switch', 'en') }}" class="hover:text-cyan-400 {{ app()->getLocale() === 'en' ? 'text-cyan-400 font-bold' : '' }}">English (EN)</a>
                        <a href="{{ route('lang.switch', 'ru') }}" class="hover:text-cyan-400 {{ app()->getLocale() === 'ru' ? 'text-cyan-400 font-bold' : '' }}">Русский (RU)</a>
                        <a href="{{ route('lang.switch', 'tk') }}" class="hover:text-cyan-400 {{ app()->getLocale() === 'tk' ? 'text-cyan-400 font-bold' : '' }}">Türkmençe (TK)</a>
                    </div>
                </div>
            </div>

            <div class="border-t border-white/5 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} AutoMarket. {{ __('market.footer_rights') }}</p>
                <div class="flex items-center gap-6">
                    <span class="inline-flex items-center gap-1.5 text-cyan-400">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                        Glassmorphism UI Engine Active
                    </span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
