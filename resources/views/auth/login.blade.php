<x-guest-layout>
    {{-- CSS Personnalisé --}}
    <link rel="stylesheet" href="{{ asset('assets/css/pages/auth.css') }}">

    <div class="auth-bg">
        <div class="auth-card">
            {{-- Logo --}}
            <a href="{{ localized_route('home') }}" class="block text-center mb-6">
                <img src="{{ asset('assets/images/logo-atz.png') }}" alt="Logo ATZ" class="auth-logo">
            </a>

            <h2 class="auth-title">Connexion</h2>
            <p class="auth-subtitle">Heureux de vous revoir parmi nous</p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-[#0da3d8] shadow-sm focus:ring-[#0da3d8]"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="auth-link text-sm" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>

                <div class="mt-6">
                    <x-primary-button class="w-full justify-center">
                        {{ __('Se connecter') }}
                    </x-primary-button>
                </div>

                <div class="text-center mt-6 text-sm text-gray-600">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="auth-link font-semibold">S'inscrire</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
