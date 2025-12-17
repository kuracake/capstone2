<x-admin-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-800">Daftar Laporan Masuk</h2>
        <p class="text-gray-400 text-sm">Pantau kendala yang dilaporkan pelanggan.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-400 uppercase bg-gray-50 font-bold border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Isi Laporan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $report->user->name ?? 'User Terhapus' }}</td>
                        <td class="px-6 py-4 text-gray-500 truncate max-w-xs">{{ $report->description }}</td>
                        <td class="px-6 py-4">
                            @if($report->status == 'pending')
                                <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-bold">Selesai</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400">{{ $report->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-teal-600 hover:text-teal-800 font-medium text-xs border border-teal-200 hover:bg-teal-50 px-3 py-1 rounded-lg transition-colors">
                                    Tandai Selesai
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-50 p-4 rounded-full mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="text-gray-500 font-medium">Belum ada laporan masuk.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>