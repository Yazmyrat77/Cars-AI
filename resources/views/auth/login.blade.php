@extends('layouts.app')

@section('title', __('market.auth_login_title') . ' - ' . __('market.app_name'))

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <!-- Centered Glass Login Card -->
    <div class="w-full max-w-md">
        
        <!-- Subtle branding above card -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 via-blue-600 to-indigo-600 items-center justify-center shadow-xl shadow-cyan-500/20 border border-white/20 mb-4 transform hover:scale-105 transition-transform">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                {{ __('market.auth_login_title') }}
            </h2>
            <p class="mt-2 text-sm text-slate-400">
                {{ __('market.auth_login_subtitle') }}
            </p>
        </div>

        <!-- Glass Box -->
        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-white/15 shadow-2xl relative overflow-hidden">
            
            <!-- Login Gate Welcome Banner -->
            <div class="mb-6 p-3.5 rounded-xl bg-cyan-500/10 border border-cyan-500/30 text-cyan-200 text-xs flex items-center gap-3">
                <svg class="w-5 h-5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ __('market.auth_gate_notice') }}</span>
            </div>

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Username or Email Field -->
                <div>
                    <label for="login" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">
                        {{ __('market.field_username_email') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               name="login" 
                               id="login" 
                               value="{{ old('login', 'admin@automarket.com') }}" 
                               required 
                               autocomplete="username"
                               placeholder="e.g. admin or admin@automarket.com"
                               class="glass-input w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-slate-500 focus:ring-2 focus:ring-cyan-400/30 @error('login') border-rose-500/80 @enderror">
                    </div>
                    @error('login')
                        <p class="mt-1.5 text-xs text-rose-400 font-medium flex items-center gap-1">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-300">
                            {{ __('market.field_password') }}
                        </label>
                        <span class="text-[11px] text-cyan-400/90 font-medium cursor-help" title="If you enter a wrong password, an automatic instant OTP code will be dispatched to your email for direct access recovery!">
                            OTP Recovery Active 🛡️
                        </span>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               required 
                               autocomplete="current-password"
                               placeholder="••••••••"
                               class="glass-input w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-slate-500 focus:ring-2 focus:ring-cyan-400/30 @error('password') border-rose-500/80 @enderror">
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-300 hover:text-white">
                        <input type="checkbox" name="remember" value="1" class="rounded bg-slate-900/60 border-white/20 text-cyan-500 focus:ring-cyan-400/30">
                        <span>{{ __('market.field_remember_me') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-cyan-500 via-blue-600 to-indigo-600 hover:from-cyan-400 hover:to-indigo-500 shadow-xl shadow-cyan-500/25 border border-white/20 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>{{ __('market.btn_login') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Quick Demo Accounts Helper Box -->
            <div class="mt-8 pt-6 border-t border-white/10">
                <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400 mb-3 text-center">
                    {{ __('market.quick_demo_accounts') }}
                </p>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <button type="button" 
                            onclick="fillCredentials('admin@automarket.com', 'password123')"
                            class="p-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-left transition-all group">
                        <div class="font-bold text-cyan-400 group-hover:text-cyan-300">Admin</div>
                        <div class="text-[10px] text-slate-400 truncate">admin@automarket.com</div>
                    </button>
                    <button type="button" 
                            onclick="fillCredentials('john@example.com', 'password123')"
                            class="p-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-left transition-all group">
                        <div class="font-bold text-indigo-400 group-hover:text-indigo-300">John Doe</div>
                        <div class="text-[10px] text-slate-400 truncate">john@example.com</div>
                    </button>
                    <button type="button" 
                            onclick="fillCredentials('dealer@automarket.com', 'password123')"
                            class="p-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-left transition-all group">
                        <div class="font-bold text-emerald-400 group-hover:text-emerald-300">Dealer</div>
                        <div class="text-[10px] text-slate-400 truncate">dealer@automarket.com</div>
                    </button>
                    <button type="button" 
                            onclick="fillWrongPassword('admin@automarket.com')"
                            class="p-2.5 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-left transition-all group"
                            title="Click to trigger wrong password OTP flow!">
                        <div class="font-bold text-amber-300 flex items-center justify-between">
                            <span>Test Wrong PW</span>
                            <span class="text-[9px] px-1 bg-amber-400/20 rounded">OTP ⚡</span>
                        </div>
                        <div class="text-[10px] text-amber-200/70">Test Recovery Flow</div>
                    </button>
                </div>
            </div>

            <!-- Register Link -->
            <div class="mt-6 text-center text-xs text-slate-400">
                {{ __('market.dont_have_account') }}
                <a href="{{ route('register') }}" class="font-semibold text-cyan-400 hover:text-cyan-300 transition-colors ml-1">
                    {{ __('market.btn_register') }}
                </a>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    function fillCredentials(login, password) {
        document.getElementById('login').value = login;
        document.getElementById('password').value = password;
    }
    function fillWrongPassword(login) {
        document.getElementById('login').value = login;
        document.getElementById('password').value = 'wrong-password-999';
    }
</script>
@endpush
@endsection

