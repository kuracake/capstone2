<x-admin-layout>
    {{-- Load Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-10 bg-gray-50/50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- HEADER: Simpel & Personal + Form Cetak --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                        Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 to-purple-600">Admin</span>
                    </h2>
                    <p class="text-gray-500 mt-2 text-sm font-medium">
                        Ringkasan performa bisnis Anda hari ini, {{ now()->translatedFormat('l, d F Y') }}.
                    </p>
                </div>
                
                {{-- Form Cetak Laporan (ANTI-GAGAL) --}}
                <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-200 flex items-center gap-2">
                    <form action="{{ route('admin.report.print') }}" method="GET" target="_blank" class="flex items-center gap-2">
                        
                        {{-- Pilihan Periode --}}
                        <div class="relative">
                            <select name="period" class="appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-2 pl-3 pr-8 rounded-lg text-sm font-bold focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:border-transparent cursor-pointer">
                                <option value="today">Hari Ini</option>
                                <option value="week">Minggu Ini</option>
                                <option value="month">Bulan Ini</option>
                                <option value="year">Tahun Ini</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md transition-transform active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>Cetak PDF</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- === BAGIAN 1: STATS CARDS (Clean Style) === --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                
                {{-- Card 1: Hari Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-fuchsia-50 text-fuchsia-600 w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-full uppercase tracking-wide">Hari Ini</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($today['revenue'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-500 mt-1 font-medium">+{{ $today['count'] }} Transaksi baru</p>
                    </div>
                </div>

                {{-- Card 2: Minggu Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-50 text-blue-600 w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-full uppercase tracking-wide">Minggu Ini</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($week['revenue'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-500 mt-1 font-medium">{{ $week['count'] }} Total transaksi</p>
                    </div>
                </div>

                {{-- Card 3: Bulan Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-violet-50 text-violet-600 w-12 h-12 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-full uppercase tracking-wide">Bulan Ini</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($month['revenue'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-500 mt-1 font-medium">{{ $month['count'] }} Total transaksi</p>
                    </div>
                </div>

                {{-- Card 4: Total Tahun --}}
                <div class="bg-gradient-to-br from-fuchsia-600 to-purple-700 p-6 rounded-2xl shadow-lg shadow-fuchsia-200 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white/20 w-12 h-12 rounded-xl flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="text-[10px] font-bold bg-white/20 px-2 py-1 rounded-full uppercase tracking-wide text-white">Tahun {{ date('Y') }}</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">Rp {{ number_format($year['revenue'], 0, ',', '.') }}</h3>
                        <p class="text-xs text-fuchsia-100 mt-1 font-medium">Total Omzet Keseluruhan</p>
                    </div>
                </div>
            </div>

            {{-- === BAGIAN 2: CHART & ALERT === --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                
                {{-- Grafik: Bersih & Elegan --}}
                <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <span class="w-2 h-6 bg-fuchsia-500 rounded-full"></span>
                        Statistik Pendapatan
                    </h3>
                    <div class="relative h-80 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                {{-- Stok Alert: Modern List --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-900">Perlu Restock</h3>
                        @if($lowStockProducts->count() > 0)
                            <span class="animate-pulse w-3 h-3 bg-red-500 rounded-full shadow-[0_0_10px_rgba(239,68,68,0.6)]"></span>
                        @endif
                    </div>

                    @if($lowStockProducts->count() > 0)
                        <div class="flex-grow space-y-4 overflow-y-auto max-h-[320px] pr-2 custom-scrollbar">
                            @foreach($lowStockProducts as $product)
                            <div class="group flex items-center gap-4 p-3 rounded-2xl hover:bg-red-50 transition-colors border border-transparent hover:border-red-100">
                                <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden shrink-0 shadow-sm">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-xs text-gray-400">No Img</div>
                                    @endif
                                </div>
                                <div class="flex-grow">
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-red-600 transition">{{ $product->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">Sisa Stok: <span class="font-bold text-red-500">{{ $product->stock }}</span></p>
                                </div>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-400 hover:text-fuchsia-600 hover:border-fuchsia-200 shadow-sm transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-center py-10">
                            <div class="w-16 h-16 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <p class="text-sm font-bold text-gray-800">Stok Aman!</p>
                            <p class="text-xs text-gray-400 mt-1">Tidak ada barang yang kritis.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- === BAGIAN 3: BEST SELLERS (Modern Table) === --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Produk Terlaris 🔥</h3>
                    <a href="{{ route('admin.products.index') }}" class="text-sm font-bold text-fuchsia-600 hover:text-fuchsia-800 hover:underline transition">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-8 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                                <th class="px-8 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Terjual</th>
                                <th class="px-8 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Stok</th>
                                <th class="px-8 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($bestSellers as $product)
                            <tr class="hover:bg-gray-50/80 transition duration-200">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-fuchsia-50 text-fuchsia-600 flex items-center justify-center font-bold text-sm">
                                            {{ substr($product->name, 0, 1) }}
                                        </div>
                                        <span class="font-bold text-gray-700">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="font-bold text-gray-900">{{ $product->total_sold }}</span>
                                    <span class="text-xs text-gray-400 ml-1">pcs</span>
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <span class="bg-gray-100 text-gray-600 py-1.5 px-3 rounded-lg text-xs font-bold">{{ $product->stock }}</span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    @if($product->total_sold > 50)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Sangat Laris
                                        </span>
                                    @elseif($product->total_sold > 20)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                            Populer
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-gray-50 text-gray-500">
                                            Normal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-gray-400 italic">Belum ada data penjualan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- STYLE: Custom Scrollbar --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 99px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: #d1d5db; }
    </style>

    {{-- SCRIPT: Chart.js Configuration --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Membuat Gradient Warna Halus
            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(236, 72, 153, 0.2)'); // Pink/Fuchsia
            gradient.addColorStop(1, 'rgba(236, 72, 153, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pendapatan',
                        data: @json($chartData),
                        borderColor: '#db2777', // Pink-600
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#db2777',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.4 // Lengkungan halus
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }, // Hilangkan legenda agar bersih
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#111827',
                            bodyColor: '#db2777',
                            borderColor: '#f3f4f6',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return ' Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6', // Grid sangat tipis
                                borderDash: [5, 5]
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 11 },
                                color: '#9ca3af',
                                callback: value => 'Rp ' + (value / 1000) + 'k'
                            },
                            border: { display: false } // Hilangkan garis sumbu Y
                        },
                        x: {
                            grid: { display: false }, // Hilangkan grid vertikal
                            ticks: {
                                font: { family: "'Inter', sans-serif", size: 11 },
                                color: '#9ca3af'
                            },
                            border: { display: false }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                }
            });
        });
    </script>
</x-admin-layout>