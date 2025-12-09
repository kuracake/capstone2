<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800">Dashboard Admin</h2>
                    <p class="text-gray-600 mt-1">Selamat datang, <span class="text-pink-600 font-semibold">{{ Auth::user()->name }}</span>!</p>
                </div>
                
                <div class="flex gap-3 mt-4 md:mt-0">
                    <a href="{{ route('products.create') }}" class="flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Produk
                    </a>
                    <a href="{{ route('tutorials.create') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z" />
                        </svg>
                        Tambah Video
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-pink-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Total Produk</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\Product::count() }}</h3>
                        </div>
                        <div class="p-3 bg-pink-100 rounded-full text-pink-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm text-pink-600 hover:text-pink-800 font-medium flex items-center">
                            Lihat semua produk &rarr;
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Pesanan Baru</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">0</h3> </div>
                        <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="#" class="text-sm text-yellow-600 hover:text-yellow-800 font-medium flex items-center">
                            Kelola Pesanan &rarr;
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm font-medium uppercase tracking-wide">Video Tutorial</p>
                            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ \App\Models\VideoTutorial::count() }}</h3>
                        </div>
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('tutorials.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                            Kelola & Update Video &rarr;
                        </a>
                    </div>
                </div>

            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-800">Pesanan Masuk (Perlu Diproses)</h3>
                    <span class="bg-pink-100 text-pink-700 text-xs font-bold px-3 py-1 rounded-full">Terbaru</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">ID Pesanan</th>
                                <th class="px-6 py-3">Pelanggan</th>
                                <th class="px-6 py-3">Total Pembayaran</th>
                                <th class="px-6 py-3">Status Saat Ini</th>
                                <th class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50 transition">
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <p>Belum ada pesanan masuk saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>