<x-guest-layout>
    
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-2">Gabung sekarang untuk mulai belanja.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-bold mb-1" />
            <x-text-input id="name" class="block mt-1 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition" 
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                          placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Alamat Email')" class="text-gray-700 font-bold mb-1" />
            <x-text-input id="email" class="block mt-1 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition" 
                          type="email" name="email" :value="old('email')" required autocomplete="username" 
                          placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold mb-1" />
            <x-text-input id="password" class="block mt-1 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-bold mb-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 shadow-sm transition"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="Ulangi password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-fuchsia-700 to-purple-700 hover:from-fuchsia-800 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fuchsia-500 transition-all transform hover:-translate-y-0.5 mt-4">
            Daftar Sekarang
        </button>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-fuchsia-600 hover:text-fuchsia-800 hover:underline">
                    Masuk disini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>