<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-8 md:py-12">
        <div class="container mx-auto px-4 md:px-6 max-w-5xl">
            
            {{-- HEADER SEDERHANA --}}
            <div class="mb-8 border-b border-gray-200 pb-6">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 font-serif">Pengaturan Profil</h1>
                <p class="text-xs md:text-sm text-gray-500 mt-1">Kelola informasi akun dan keamanan kata sandi Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: INFO PROFIL --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- KOLOM KANAN: KEAMANAN & AKUN --}}
                <div class="space-y-6">
                    {{-- Ganti Password --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Hapus Akun --}}
                    <div class="bg-red-50 p-6 rounded-xl border border-red-100 shadow-sm">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>