<x-admin-layout>
    
    {{-- HEADER & TOMBOL TAMBAH --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 font-serif">Katalog Tutorial</h2>
            <p class="text-sm text-gray-500">Kelola video panduan dan tips perawatan untuk pelanggan.</p>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-fuchsia-600 text-white text-sm font-bold rounded-xl hover:bg-fuchsia-700 transition shadow-lg shadow-fuchsia-200 gap-2 transform hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            Tambah Video
        </a>
    </div>

    {{-- NOTIFIKASI SUKSES --}}
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center p-4 bg-green-50 border-l-4 border-green-500 rounded-r-xl shadow-sm">
            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-green-800 font-medium text-sm">{{ session('success') }}</span>
            <button @click="show = false" class="ml-auto text-green-400 hover:text-green-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
    @endif

    {{-- TABEL VIDEO --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase text-gray-400 font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-5">Judul Video</th>
                        <th class="px-6 py-5">Deskripsi</th>
                        <th class="px-6 py-5 text-center">Preview</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($videos as $video)
                        <tr class="hover:bg-fuchsia-50/30 transition duration-200 group">
                            
                            {{-- Judul --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center shrink-0 border border-red-100">
                                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                    </div>
                                    <span class="font-bold text-gray-800 text-sm group-hover:text-fuchsia-700 transition">{{ $video->title }}</span>
                                </div>
                            </td>

                            {{-- Deskripsi --}}
                            <td class="px-6 py-4">
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 max-w-xs">
                                    {{ Str::limit($video->description ?? 'Tidak ada deskripsi', 60) }}
                                </p>
                            </td>

                            {{-- Link Preview (Opsional, jika ada kolom link/youtube_id) --}}
                            <td class="px-6 py-4 text-center">
                                @if(!empty($video->youtube_id))
                                    <a href="https://www.youtube.com/watch?v={{ $video->youtube_id }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-gray-50 border border-gray-200 rounded-full text-xs font-bold text-gray-500 hover:text-red-600 hover:border-red-200 transition">
                                        Tonton
                                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @else
                                    <span class="text-xs text-gray-300 italic">No Link</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Hapus video ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Belum ada tutorial</h3>
                                    <p class="text-gray-500 text-sm mt-1 mb-4">Tambahkan video edukasi untuk pelanggan Anda.</p>
                                    <a href="{{ route('admin.videos.create') }}" class="px-5 py-2 bg-fuchsia-600 text-white rounded-lg text-sm font-bold hover:bg-fuchsia-700 transition">
                                        + Buat Tutorial Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination jika ada --}}
        @if(isset($videos) && $videos instanceof \Illuminate\Pagination\LengthAwarePaginator && $videos->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $videos->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>