<x-guest-layout>
    
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-sm text-gray-500 mt-2">Masuk untuk mengelola pesanan Anda.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-bold mb-1" />
            <x-text-input id="email" 
                          class="block mt-1 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition" 
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                          placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-fuchsia-600 hover:text-fuchsia-800" href="{{ route('password.request') }}">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <x-text-input id="password" 
                          class="block mt-1 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition"
                          type="password"
                          name="password"
                          required autocomplete="current-password"
                          placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-fuchsia-600 shadow-sm focus:ring-fuchsia-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-fuchsia-700 to-purple-700 hover:from-fuchsia-800 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-all transform hover:-translate-y-0.5">
            Masuk Sekarang
        </button>

        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Belum punya akun?</span>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('register') }}" class="inline-block font-bold text-fuchsia-600 hover:text-fuchsia-800 hover:underline">
                Daftar Akun Baru
            </a>
        </div>
    </form>
</x-guest-layout>