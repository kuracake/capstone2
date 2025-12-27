<section x-data="{ isEditing: {{ $errors->any() ? 'true' : 'false' }} }">
    
    {{-- HEADER & TOMBOL TOGGLE --}}
    <header class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">
            Informasi Pribadi
        </h2>
        
        {{-- Tombol Edit (Menggunakan Warna Tema Fuchsia) --}}
        <button x-show="!isEditing" 
                @click="isEditing = true" 
                class="text-xs font-bold text-fuchsia-600 hover:text-fuchsia-800 flex items-center gap-1 transition rounded-lg px-3 py-1.5 hover:bg-fuchsia-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            Ubah Profil
        </button>
    </header>

    {{-- ================= MODE LIHAT (VIEW ONLY) ================= --}}
    <div x-show="!isEditing" class="space-y-6 animate-fade-in">
        
        {{-- Foto Profil & Nama Utama --}}
        <div class="flex items-center gap-5">
            <div class="shrink-0">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="h-20 w-20 rounded-full object-cover border-4 border-fuchsia-50 shadow-sm">
                @else
                    {{-- Placeholder sesuai tema --}}
                    <div class="h-20 w-20 rounded-full bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center font-bold text-2xl border-4 border-white shadow-sm">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div>
                {{-- Nama menggunakan warna gelap yang tegas --}}
                <h3 class="text-xl font-bold text-gray-900 tracking-tight">{{ $user->name }}</h3>
                {{-- Email dibuat lebih halus --}}
                <p class="text-sm text-gray-500 font-medium">{{ $user->email }}</p>
                {{-- Bagian "Member Aktif" telah DIHAPUS di sini --}}
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8 pt-6 border-t border-gray-50">
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Nomor WhatsApp</span>
                <p class="text-sm font-semibold text-gray-800">{{ $user->phone ?? '-' }}</p>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Jenis Kelamin</span>
                <p class="text-sm font-semibold text-gray-800">{{ $user->gender ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <span class="block text-xs font-bold text-gray-400 uppercase mb-1 tracking-wider">Alamat Lengkap</span>
                <p class="text-sm font-medium text-gray-800 leading-relaxed">{{ $user->address ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- ================= MODE EDIT (FORM) ================= --}}
    <form x-show="isEditing" 
          method="post" 
          action="{{ route('profile.update') }}" 
          enctype="multipart/form-data" 
          class="space-y-5 hidden" 
          :class="{'hidden': !isEditing}">
        @csrf
        @method('patch')

        {{-- Upload Foto dengan aksen tema --}}
        <div class="flex items-center gap-6 pb-6 border-b border-gray-100">
            <div class="shrink-0">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" class="h-16 w-16 rounded-full object-cover border-2 border-fuchsia-200">
                @else
                    <div class="h-16 w-16 rounded-full bg-fuchsia-50 flex items-center justify-center text-fuchsia-600 font-bold text-xl border-2 border-fuchsia-200">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="w-full">
                <label class="block text-xs font-bold text-gray-700 mb-2">Ganti Foto Profil</label>
                <input type="file" name="avatar" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-fuchsia-100 file:text-fuchsia-700 hover:file:bg-fuchsia-200 cursor-pointer transition">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Nama --}}
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold text-gray-700 uppercase tracking-wider" />
                <x-text-input id="name" name="name" type="text" class="mt-2 block w-full text-sm border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-4 py-3 font-medium" :value="old('name', $user->name)" required />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Alamat Email')" class="text-xs font-bold text-gray-700 uppercase tracking-wider" />
                <x-text-input id="email" name="email" type="email" class="mt-2 block w-full text-sm border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-4 py-3 font-medium bg-gray-100 text-gray-500 cursor-not-allowed" :value="old('email', $user->email)" readonly />
            </div>
        </div>

        {{-- No HP & Gender --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <x-input-label for="phone" :value="__('Nomor WhatsApp')" class="text-xs font-bold text-gray-700 uppercase tracking-wider" />
                <x-text-input id="phone" name="phone" type="number" class="mt-2 block w-full text-sm border-gray-300 focus:border-fuchsia-500 focus:ring-fuchsia-500 rounded-xl px-4 py-3 font-medium" :value="old('phone', $user->phone)" placeholder="Contoh: 08123456789" />
            </div>
            <div>
                <x-input-label for="gender" :value="__('Jenis Kelamin')" class="text-xs font-bold text-gray-700 uppercase tracking-wider" />
                <select name="gender" id="gender" class="mt-2 block w-full text-sm border-gray-300 rounded-xl px-4 py-3 font-medium focus:ring-fuchsia-500 focus:border-fuchsia-500 cursor-pointer appearance-none bg-white">
                    <option value="">-- Pilih --</option>
                    <option value="Laki-laki" {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <x-input-label for="address" :value="__('Alamat Lengkap')" class="text-xs font-bold text-gray-700 uppercase tracking-wider" />
            <textarea id="address" name="address" rows="3" class="mt-2 block w-full text-sm border-gray-300 rounded-xl px-4 py-3 font-medium focus:border-fuchsia-500 focus:ring-fuchsia-500 transition" placeholder="Nama Jalan, RT/RW, Kelurahan...">{{ old('address', $user->address) }}</textarea>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
            <button type="submit" class="px-8 py-3 bg-fuchsia-600 text-white text-xs font-bold rounded-xl hover:bg-fuchsia-700 transition shadow-md shadow-fuchsia-200 hover:shadow-lg transform active:scale-95">
                Simpan Perubahan
            </button>
            <button type="button" @click="isEditing = false" class="px-6 py-3 bg-white text-gray-600 text-xs font-bold rounded-xl border border-gray-300 hover:bg-gray-50 transition">
                Batal
            </button>
        </div>
    </form>
</section>