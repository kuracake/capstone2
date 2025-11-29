<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin - Daftar Komplain Masuk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="p-2">Pelapor</th>
                            <th class="p-2">Masalah</th>
                            <th class="p-2">Foto</th>
                            <th class="p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr class="border-b">
                            <td class="p-2">{{ $report->user->name }}</td>
                            <td class="p-2">{{ $report->subject }}</td>
                            <td class="p-2">
                                <a href="{{ asset('storage/' . $report->evidence_image_path) }}" target="_blank" class="text-blue-600 underline">Lihat Foto</a>
                            </td>
                            <td class="p-2 text-red-600 font-bold">{{ $report->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>