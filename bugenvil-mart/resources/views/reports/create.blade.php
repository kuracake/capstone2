<x-app-layout>
    <div class="bg-pink-50 min-h-screen py-12 flex items-center justify-center px-4">
        
        <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row">
            
            <div class="bg-fuchsia-500 md:w-2/5 p-12 text-white flex flex-col justify-center relative overflow-hidden">
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-10 right-10 w-32 h-32 bg-purple-600/20 rounded-full blur-xl"></div>

                <div class="relative z-10">
                    <div class="bg-white/20 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl font-bold serif mb-4">Laporkan Masalah</h2>
                    <p class="text-fuchsia-100 mb-8 leading-relaxed">
                        Menerima bunga yang rusak atau layu? Kami di sini untuk membantu! Kirimkan laporan dengan foto dan kami akan menyelesaikannya dengan cepat.
                    </p>

                    <ul class="space-y-4 text-sm font-medium">
                        <li class="flex items-center gap-3">
                            <div class="bg-white/20 p-1 rounded-full"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            Respon cepat dalam 24 jam
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="bg-white/20 p-1 rounded-full"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            Penggantian atau Refund Penuh
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="bg-white/20 p-1 rounded-full"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></div>
                            Lacak status laporan Anda
                        </li>
                    </ul>
                </div>
            </div>

            <div class="bg-white md:w-3/5 p-12">
                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Judul Masalah / Nomor Order</label>
                        <input type="text" name="subject" class="w-full border-gray-200 rounded-xl p-3 focus:ring-fuchsia-500 focus:border-fuchsia-500 bg-gray-50" placeholder="cth: Bunga Layu - ORD123" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Deskripsi Masalah</label>
                        <textarea name="description" rows="4" class="w-full border-gray-200 rounded-xl p-3 focus:ring-fuchsia-500 focus:border-fuchsia-500 bg-gray-50" placeholder="Jelaskan kondisi bunga yang Anda terima..." required></textarea>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-sm">Upload Foto Bukti</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 transition cursor-pointer relative">
                            <input type="file" name="evidence" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="mt-1 text-sm text-gray-600">Klik untuk upload atau drag and drop</p>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG up to 10MB</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-fuchsia-500 text-white font-bold py-4 rounded-xl shadow-lg hover:bg-fuchsia-600 transition transform hover:-translate-y-1">
                        Kirim Laporan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>