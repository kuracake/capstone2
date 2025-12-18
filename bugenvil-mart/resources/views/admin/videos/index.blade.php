<x-admin-layout>
    <div class="py-4 md:py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">
            
            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Katalog Tutorial</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola daftar panduan dan tutorial untuk pelanggan.</p>
                </div>
                <a href="{{ route('admin.videos.create') }}" class="inline-flex items-center justify-center px-5 py-3 bg-teal-600 text-white rounded-xl font-bold text-sm shadow-md hover:bg-teal-700 transition-all">
                    + Tambah Tutorial
                </a>
            </div>

            {{-- Desktop View (Tabel) --}}
            <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-bold">
                        <tr>
                            <th class="px-6 py-4">Judul Tutorial</th>
                            <th class="px-6 py-4">Deskripsi Singkat</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-700">
                        @foreach($videos as $video)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">{{ $video->title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-500 line-clamp-1">{{ $video->description }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="text-blue-500 p-2 hover:bg-blue-50 rounded-lg transition-colors font-bold">Edit</a>
                                    <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Hapus tutorial ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 p-2 hover:bg-red-50 rounded-lg font-bold">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile View (Card List) --}}
            <div class="md:hidden space-y-3">
                @forelse($videos as $video)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="mb-3">
                        <span class="bg-teal-50 text-teal-600 text-[10px] font-black px-2 py-1 rounded-md uppercase">Konten Tutorial</span>
                        <h4 class="font-bold text-gray-900 leading-tight mt-2">{{ $video->title }}</h4>
                    </div>
                    <p class="text-xs text-gray-500 mb-4 line-clamp-3">{{ $video->description }}</p>
                    <div class="flex items-center justify-end pt-4 border-t border-gray-50 gap-4">
                        <a href="{{ route('admin.videos.edit', $video->id) }}" class="text-blue-500 text-xs font-bold uppercase tracking-wider">Edit</a>
                        <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-400 text-xs font-bold uppercase tracking-wider">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="bg-white p-10 rounded-3xl border border-dashed border-gray-200 text-center">
                    <p class="text-gray-400 text-sm italic">Belum ada tutorial yang ditambahkan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $videos->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>