<x-admin-layout>
    <div class="py-4 md:py-8 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('admin.videos.index') }}" class="inline-flex items-center text-teal-600 font-bold text-sm mb-1 hover:text-teal-700 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Batal
                    </a>
                    <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">Edit Tutorial</h2>
                </div>
            </div>

            <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                @csrf
                @method('PUT')

                <div class="bg-white p-5 md:p-6 rounded-2xl shadow-sm border border-gray-100 space-y-5">
                    <div>
                        <x-input-label for="title" :value="__('Judul Tutorial')" class="font-bold text-gray-700" />
                        <x-text-input id="title" class="block w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl" type="text" name="title" :value="old('title', $video->title)" required />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Deskripsi')" class="font-bold text-gray-700" />
                        <textarea id="description" name="description" rows="5" class="block w-full mt-1 border-gray-200 focus:ring-teal-500 rounded-xl shadow-sm" required>{{ old('description', $video->description) }}</textarea>
                    </div>

                    {{-- Area Pratinjau Video --}}
                    <div>
                        <x-input-label :value="__('Video Tutorial')" class="font-bold text-gray-700 mb-2" />
                        
                        <div id="video-preview-container" class="mb-4 p-2 bg-gray-50 rounded-xl border border-gray-100 {{ $video->video_url ? '' : 'hidden' }}">
                            <p id="preview-label" class="text-[10px] text-gray-400 uppercase font-black mb-2 px-1 italic">
                                {{ $video->video_url ? 'Video Saat Ini:' : 'Pratinjau Video Baru:' }}
                            </p>
                            <video id="video-preview-player" class="w-full rounded-lg shadow-sm" controls>
                                @if($video->video_url)
                                    <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                @endif
                            </video>
                        </div>

                        <label for="video_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-2xl cursor-pointer hover:bg-gray-50 transition-all group">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center px-4">
                                <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <p class="text-xs text-gray-500"><span class="font-bold text-teal-600">Klik untuk pilih file video</span></p>
                            </div>
                            <input id="video_file" name="video_file" type="file" class="hidden" accept="video/*" onchange="previewVideo(event)" />
                        </label>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 bg-teal-600 text-white rounded-2xl font-bold text-lg shadow-lg hover:bg-teal-700 active:scale-95 transition-all">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewVideo(event) {
            const file = event.target.files[0];
            if (file) {
                const container = document.getElementById('video-preview-container');
                const player = document.getElementById('video-preview-player');
                const label = document.getElementById('preview-label');
                
                const fileURL = URL.createObjectURL(file);
                player.src = fileURL;
                label.innerText = 'Pratinjau Video Baru (Belum Disimpan):';
                container.classList.remove('hidden');
                player.load();
            }
        }
    </script>
</x-admin-layout>