<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Laporan Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Semua Laporan Kendala</h3>

                @if($reports->isEmpty())
                    <p class="text-gray-500">Belum ada laporan masuk.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="p-3">Pelapor</th>
                                    <th class="p-3">Nomor Order</th>
                                    <th class="p-3">Deskripsi Masalah</th>
                                    <th class="p-3">Bukti Foto</th>
                                    <th class="p-3">Status</th>
                                    <th class="p-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reports as $report)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-bold">{{ $report->user->name }}</td>
                                    <td class="p-3">{{ $report->subject }}</td>
                                    <td class="p-3 text-sm text-gray-600 w-1/3">{{ $report->description }}</td>
                                    <td class="p-3">
                                        @if($report->evidence_image_path)
                                            <a href="{{ asset('storage/' . $report->evidence_image_path) }}" target="_blank" class="text-blue-600 underline text-sm">
                                                Lihat Foto
                                            </a>
                                        @else
                                            <span class="text-gray-400 text-xs">Tidak ada foto</span>
                                        @endif
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold 
                                            {{ $report->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3">
                                        <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                            @csrf 
                                            @method('PATCH')
                                            
                                            <select name="status" onchange="this.form.submit()" 
                                                class="text-xs border-gray-300 rounded shadow-sm focus:border-fuchsia-500 focus:ring focus:ring-fuchsia-200 focus:ring-opacity-50 cursor-pointer 
                                                {{ $report->status == 'resolved' ? 'text-green-600 font-bold' : '' }}
                                                {{ $report->status == 'rejected' ? 'text-red-600 font-bold' : '' }}">
                                                
                                                <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>
                                                    ⏳ Pending
                                                </option>
                                                <option value="processing" {{ $report->status == 'processing' ? 'selected' : '' }}>
                                                    ⚙️ Proses
                                                </option>
                                                <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>
                                                    ✅ Selesai
                                                </option>
                                                <option value="rejected" {{ $report->status == 'rejected' ? 'selected' : '' }}>
                                                    ❌ Tolak
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>