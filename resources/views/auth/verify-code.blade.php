@extends('layouts.app')

@section('title', __('market.otp_title') . ' - ' . __('market.app_name'))

@section('content')
<div class="min-h-[85vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <div class="w-full max-w-md">
        
        <!-- Header with Glowing Security Shield -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-500 via-orange-600 to-rose-600 items-center justify-center shadow-xl shadow-amber-500/25 border border-white/20 mb-4 animate-bounce">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">
                {{ __('market.otp_title') }}
            </h2>
            <p class="mt-2 text-sm text-slate-400 max-w-sm mx-auto">
                {{ __('market.otp_subtitle') }}
            </p>
        </div>

        <!-- Glass Box -->
        <div class="glass-panel rounded-3xl p-8 sm:p-10 border border-white/15 shadow-2xl relative overflow-hidden">
            
            <!-- Target Account Banner -->
            <div class="mb-6 p-4 rounded-2xl bg-white/5 border border-white/10 text-xs text-slate-300 space-y-1">
                <div class="text-slate-400 uppercase text-[10px] font-bold tracking-wider">Account Email:</div>
                <div class="font-mono text-cyan-400 font-semibold text-sm">{{ $email }}</div>
            </div>

            <!-- Demo / Evaluation Helper Badge -->
            @if ($demoCode)
            <div class="mb-6 p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-300">
                        ⚡ {{ __('market.otp_demo_hint') }}
                    </span>
                    <button type="button" 
                            onclick="autoFillOtp('{{ $demoCode }}')"
                            class="text-[11px] font-bold px-2 py-0.5 rounded bg-amber-400/20 hover:bg-amber-400/30 text-amber-200 border border-amber-400/40 transition-all">
                        Click to Autofill
                    </button>
                </div>
                <div class="text-2xl font-mono font-black tracking-widest text-white text-center py-1 bg-black/30 rounded-xl border border-white/10 select-all cursor-pointer"
                     onclick="autoFillOtp('{{ $demoCode }}')">
                    {{ $demoCode }}
                </div>
            </div>
            @endif

            <form action="{{ route('auth.verify.submit') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- OTP Input -->
                <div>
                    <label for="code" class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2 text-center">
                        {{ __('market.otp_input_label') }}
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="code" 
                               id="code" 
                               maxlength="6"
                               required 
                               autocomplete="one-time-code"
                               placeholder="123456"
                               value="{{ old('code', $demoCode ?? '') }}"
                               class="glass-input w-full py-4 text-center text-3xl font-mono font-black tracking-[0.5em] rounded-2xl focus:ring-4 focus:ring-amber-500/30 border-white/20 @error('code') border-rose-500 @enderror">
                    </div>
                    @error('code')
                        <p class="mt-2 text-xs text-rose-400 font-medium text-center">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-[11px] text-slate-400 text-center">
                        {{ __('market.otp_expires_in') }}
                    </p>
                </div>

                <!-- Verify Button -->
                <div>
                    <button type="submit" 
                            class="w-full py-3.5 px-4 rounded-xl text-sm font-bold uppercase tracking-wider text-white bg-gradient-to-r from-amber-500 via-orange-600 to-rose-600 hover:from-amber-400 hover:to-rose-500 shadow-xl shadow-amber-500/25 border border-white/20 transition-all duration-300 hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2">
                        <span>{{ __('market.otp_submit_btn') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-xs text-slate-400 hover:text-cyan-400 transition-colors inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('market.otp_back_to_login') }}
                </a>
            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    function autoFillOtp(code) {
        document.getElementById('code').value = code;
    }
</script>
@endpush
@endsection

