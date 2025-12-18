<x-admin-layout>
    <div class="py-4 md:py-8 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.videos.index') }}" class="inline-flex items-center text-teal-600 font-bold text-sm mb-1 hover:text-teal-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Kembali
                    </a>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">Tambah Tutorial Video</h2>
                </div>
            </div>

            <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                @csrf
                <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
                    {{-- Input Judul --}}
                    <div>
                        <x-input-label for="title" :value="__('Judul Tutorial')" class="font-bold text-gray-700" />
                        <x-text-input id="title" class="block w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl" type="text" name="title" :value="old('title')" required placeholder="Misal: Cara Menanam Bugenvil" />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    {{-- Input Deskripsi --}}
                    <div>
                        <x-input-label for="description" :value="__('Deskripsi / Panduan Teks')" class="font-bold text-gray-700" />
                        <textarea id="description" name="description" rows="6" class="block w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl shadow-sm" required placeholder="Tuliskan panduan lengkap di sini...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    {{-- Area Pratinjau Video --}}
                    <div>
                        <x-input-label :value="__('File Video')" class="font-bold text-gray-700 mb-2" />
                        
                        {{-- Container Pratinjau (Awalnya Tersembunyi) --}}
                        <div id="video-preview-container" class="hidden mb-4 p-2 bg-gray-50 rounded-xl border border-teal-100 shadow-inner">
                            <p class="text-[10px] text-teal-600 uppercase font-black mb-2 px-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Video Siap Diunggah:
                            </p>
                            <video id="video-preview-player" class="w-full rounded-lg shadow-sm max-h-64 object-cover" controls>
                                Browser Anda tidak mendukung pemutar video.
                            </video>
                        </div>

                        {{-- Input Unggah --}}
                        <label for="video_file" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer hover:bg-teal-50/50 hover:border-teal-300 transition-all group overflow-hidden">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <p class="text-sm text-gray-600"><span class="font-bold text-teal-600">Klik untuk pilih video</span> atau seret file</p>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">MP4, MOV (Maks. 20MB)</p>
                            </div>
                            <input id="video_file" name="video_file" type="file" class="hidden" accept="video/*" required onchange="previewVideo(event)" />
                        </label>
                        <x-input-error :messages="$errors->get('video_file')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-teal-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-teal-100 hover:bg-teal-700 active:scale-95 transition-all flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan Tutorial
                    </button>
                    <p class="text-[10px] text-center text-gray-400 mt-4 italic">Proses unggah video mungkin memerlukan waktu tergantung ukuran file.</p>
                </div>
            </form>
        </div>
    </div>

    {{-- Script JavaScript untuk Pratinjau --}}
    <script>
        function previewVideo(event) {
            const file = event.target.files[0];
            if (file) {
                const container = document.getElementById('video-preview-container');
                const player = document.getElementById('video-preview-player');
                
                // Membuat URL sementara untuk file video yang dipilih
                const fileURL = URL.createObjectURL(file);
                player.src = fileURL;
                
                // Menampilkan container pratinjau
                container.classList.remove('hidden');
                
                // Memuat ulang player untuk menerapkan source baru
                player.load();
            }
        }
    </script>
</x-admin-layout>