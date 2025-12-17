<x-admin-layout>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Kelola Video Tutorial</h2>
        <a href="{{ route('admin.videos.create') }}" class="px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white rounded-xl font-semibold text-sm transition-colors shadow-lg shadow-teal-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Video
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-400 uppercase bg-gray-50 font-bold border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4">Judul Video</th>
                    <th class="px-6 py-4">Preview</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($videos as $video)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $video->title }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ $video->url }}" target="_blank" class="text-teal-500 hover:text-teal-700 underline text-xs font-semibold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Lihat Video
                        </a>
                    </td>
                    <td class="px-6 py-4 flex justify-center gap-3">
                        <a href="{{ route('admin.videos.edit', $video->id) }}" class="text-blue-500 hover:text-blue-700 font-medium text-xs">Edit</a>
                        <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">Belum ada video tutorial.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>