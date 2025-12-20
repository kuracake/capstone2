<x-admin-layout>
    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Laporan Kendala Pelanggan</h2>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-400 uppercase text-[11px] font-bold">
                            <tr>
                                <th class="px-6 py-4 italic">Pelanggan</th>
                                <th class="px-6 py-4 italic">No. Pesanan</th>
                                <th class="px-6 py-4 italic">Detail Kendala</th>
                                <th class="px-6 py-4 text-center italic">Bukti Foto</th>
                                <th class="px-6 py-4 text-right italic">Status / Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($reports as $report)
                            <tr class="hover:bg-gray-50/50">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $report->user->name }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-mono text-teal-600 font-bold bg-teal-50 px-2 py-1 rounded">
                                        {{-- Mengambil tracking_number melalui relasi order --}}
                                        {{ $report->order->tracking_number ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 italic">
                                    "{{ $report->description }}"
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($report->evidence_image_path)
                                        <a href="{{ asset('storage/' . $report->evidence_image_path) }}" target="_blank" class="text-teal-600 font-bold underline text-xs">
                                            Buka Foto
                                        </a>
                                    @else
                                        <span class="text-gray-300 italic text-xs">Tanpa Foto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-xs">
                                    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="rounded-lg border-gray-200 py-1 text-[10px]">
                                            <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic font-medium">Belum ada laporan kendala masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>