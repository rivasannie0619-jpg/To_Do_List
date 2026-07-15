<x-guest-layout>
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Welcome back</h2>
    <p class="text-gray-500 text-sm mb-6">Log in to view your To-Do List.</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-gray-900 shadow-sm focus:ring-gray-900" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900 underline" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <button type="submit" class="w-full bg-gray-900 text-white py-2.5 rounded-md font-semibold text-sm hover:bg-gray-800 transition">
            {{ __('Log in') }}
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-500 pt-2">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-gray-900 font-semibold underline">Sign up</a>
            </p>
        @endif
    </form>
</x-guest-layout>