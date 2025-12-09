<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Kelola Video Tutorial</h2>
                <a href="{{ route('admin.videos.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow transition">
                    + Tambah Video
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <th class="px-5 py-3 border-b-2 border-gray-200">Judul Video</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">Preview</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($videos as $video)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-semibold">{{ $video->title }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <a href="{{ asset('storage/' . $video->video_url) }}" target="_blank" class="text-blue-600 hover:underline">
                                        Lihat Video
                                    </a>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.videos.edit', $video->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                            Edit
                                        </a>
                                        <span class="text-gray-300">|</span>
                                        
                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus video ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center text-gray-500">
                                    Belum ada video tutorial.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>