@extends('layouts.app')

@section('title', __('market.auth_register_title') . ' - ' . __('market.app_name'))

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <div class="w-full max-w-lg">
        
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 via-blue-600 to-indigo-600 items-center justify-center shadow-xl shadow-cyan-500/20 border border-white/20 mb-4 transform hover:scale-105 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                {{ __('market.auth_register_title') }}
            </h2>
            <p class="mt-2 text-sm text-slate-400">
                {{ __('market.auth_register_subtitle') }}
            </p>
        </div>

        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-white/15 shadow-2xl relative overflow-hidden">
            
            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_name') }}
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}" 
                           required 
                           placeholder="e.g. John Doe"
                           class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username & Email (2 columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            {{ __('market.field_username') }}
                        </label>
                        <input type="text" 
                               name="username" 
                               id="username" 
                               value="{{ old('username') }}" 
                               required 
                               placeholder="e.g. johndoe"
                               class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('username') border-rose-500 @enderror">
                        @error('username')
                            <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            {{ __('market.field_email') }}
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}" 
                               required 
                               placeholder="john@example.com"
                               class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('email') border-rose-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password & Confirm Password (2 columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            {{ __('market.field_password') }}
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required 
                               placeholder="••••••••"
                               class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500 @error('password') border-rose-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-xs text-rose-400 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                            {{ __('market.field_password_confirm') }}
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               required 
                               placeholder="••••••••"
                               class="glass-input w-full px-4 py-3 rounded-xl text-sm placeholder-slate-500">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-xl shadow-cyan-500/25 border border-white/20 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>{{ __('market.btn_register') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center text-xs text-slate-400">
                {{ __('market.already_have_account') }}
                <a href="{{ route('login') }}" class="font-semibold text-cyan-400 hover:text-cyan-300 transition-colors ml-1">
                    {{ __('market.btn_login') }}
                </a>
            </div>

        </div>

    </div>

</div>
@endsection

