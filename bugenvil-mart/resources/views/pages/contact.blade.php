<x-app-layout>
    <div class="bg-white py-16">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row gap-12">
                <div class="md:w-1/2">
                    <h1 class="text-4xl font-bold serif text-fuchsia-600 mb-6">Hubungi Kami</h1>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Punya pertanyaan seputar perawatan bunga atau status pesanan? Tim ahli kami siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-100 p-3 rounded-lg text-purple-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>
                            <div>
                                <h4 class="font-bold text-gray-800">Alamat Toko</h4>
                                <p class="text-gray-500">Jl. Kebun Raya No. 88, Bogor, Jawa Barat</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-100 p-3 rounded-lg text-purple-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                            <div>
                                <h4 class="font-bold text-gray-800">Email</h4>
                                <p class="text-gray-500">support@bougainvilla.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 bg-gray-50 p-8 rounded-3xl">
                    <form onsubmit="alert('Pesan terkirim! Kami akan menghubungi Anda segera.'); return false;">
                        <div class="mb-4">
                            <label class="block font-bold text-sm mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full border-gray-200 rounded-lg p-3" required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold text-sm mb-2">Email</label>
                            <input type="email" class="w-full border-gray-200 rounded-lg p-3" required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold text-sm mb-2">Pesan</label>
                            <textarea rows="4" class="w-full border-gray-200 rounded-lg p-3" required></textarea>
                        </div>
                        <button class="w-full bg-fuchsia-600 text-white font-bold py-3 rounded-lg hover:bg-fuchsia-700">Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>