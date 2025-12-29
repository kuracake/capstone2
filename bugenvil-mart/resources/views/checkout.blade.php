<x-app-layout>
    {{-- Load jQuery (Wajib) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <div class="bg-gray-50/50 min-h-screen py-8 md:py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
            
            {{-- Header Checkout --}}
            <div class="text-center mb-10 md:mb-14">
                <h1 class="text-3xl md:text-4xl font-bold serif text-gray-900 mb-2">Checkout</h1>
                <p class="text-gray-500 text-sm md:text-base">Lengkapi data pengiriman untuk menyelesaikan pesanan Anda.</p>
            </div>

            {{-- Error Message --}}
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-8 flex items-center gap-3 shadow-sm max-w-4xl mx-auto">
                    <svg class="w-6 h-6 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
                @csrf
                
                {{-- === KOLOM KIRI: FORM ALAMAT === --}}
                <div class="w-full lg:w-2/3 space-y-6">
                    
                    {{-- FITUR BARU: PILIH ALAMAT TERSIMPAN (Hanya muncul jika ada alamat) --}}
                    @if(isset($savedAddresses) && $savedAddresses->count() > 0)
                    <div class="bg-blue-50 border border-blue-100 p-6 rounded-3xl shadow-sm">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Gunakan Alamat Tersimpan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($savedAddresses as $addr)
                            <div class="relative">
                                <input type="radio" name="selected_address_trigger" id="addr_{{ $addr->id }}" 
                                    class="peer hidden"
                                    onclick="fillAddress(
                                        '{{ $addr->address_detail }}', 
                                        '{{ $addr->postal_code }}', 
                                        '{{ $addr->province_id }}', '{{ $addr->province_name }}', 
                                        '{{ $addr->city_id }}', '{{ $addr->city_name }}', 
                                        '{{ $addr->district_id }}', '{{ $addr->district_name }}',
                                        '{{ $addr->village_name ?? '' }}'
                                    )">
                                <label for="addr_{{ $addr->id }}" class="block p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all">
                                    <div class="font-bold text-gray-800 text-sm">{{ $addr->district_name }}, {{ $addr->city_name }}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $addr->address_detail }}</div>
                                    <div class="text-xs text-blue-600 font-semibold mt-1">Pilih Alamat Ini</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" onclick="window.location.reload()" class="mt-4 text-xs text-red-500 underline font-semibold">
                            Reset / Input Alamat Baru Manual
                        </button>
                    </div>
                    @endif
                    
                    {{-- Card: Form Alamat Manual (Program Asli Anda) --}}
                    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-lg shadow-gray-100 border border-gray-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-fuchsia-500"></div> 
                        
                        <h2 class="text-xl font-bold mb-8 flex items-center gap-3 text-gray-800 border-b border-gray-100 pb-4">
                            <span class="bg-fuchsia-100 text-fuchsia-600 w-10 h-10 flex items-center justify-center rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            Alamat Pengiriman
                        </h2>

                        <div class="space-y-6">
                            {{-- Nama Penerima --}}
                            <div class="relative group">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Penerima</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    </div>
                                    <input type="text" class="w-full border-gray-200 rounded-xl pl-12 pr-4 py-3.5 bg-gray-50 text-gray-700 font-semibold focus:ring-0 focus:border-gray-300 cursor-default" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>

                            {{-- Grid Wilayah (Provinsi & Kota) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Provinsi <span class="text-red-500">*</span></label>
                                    <select name="province_id" id="province_id" class="w-full border-gray-300 rounded-xl p-3.5 focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500 transition shadow-sm" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                    <input type="hidden" name="province_name" id="province_name">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kota / Kabupaten <span class="text-red-500">*</span></label>
                                    <select name="city_id" id="city_id" class="w-full border-gray-300 rounded-xl p-3.5 bg-gray-100 text-gray-500 cursor-not-allowed" disabled required>
                                        <option value="">-- Pilih Provinsi Dulu --</option>
                                    </select>
                                    <input type="hidden" name="city_name" id="city_name">
                                </div>
                            </div>

                            {{-- Grid Wilayah (Kecamatan & Desa) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kecamatan <span class="text-red-500">*</span></label>
                                    <select name="district_id" id="district_id" class="w-full border-gray-300 rounded-xl p-3.5 bg-gray-100 text-gray-500 cursor-not-allowed" disabled required>
                                        <option value="">-- Pilih Kota Dulu --</option>
                                    </select>
                                    <input type="hidden" name="district_name" id="district_name">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Desa / Kelurahan <span class="text-red-500">*</span></label>
                                    <input type="text" name="village_name" id="village_name" class="w-full border-gray-300 rounded-xl p-3.5 focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500 transition shadow-sm" placeholder="Contoh: Ds. Sukamaju" required>
                                </div>
                            </div>

                            {{-- Detail Jalan --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Lengkap (Jalan/RT/RW) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        </div>
                                        <input type="text" name="address_detail" id="address_detail" class="w-full border-gray-300 rounded-xl pl-12 pr-4 p-3.5 focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500 transition shadow-sm" placeholder="Contoh: Jl. Mawar No. 10, Depan Masjid" required>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kode Pos</label>
                                    <input type="text" name="postal_code" id="postal_code" class="w-full border-gray-300 rounded-xl p-3.5 focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500 transition shadow-sm text-center font-bold text-gray-700 tracking-widest" placeholder="Contoh: 61256">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- === KOLOM KANAN: PENGIRIMAN & RINGKASAN (STICKY) === --}}
                <div class="w-full lg:w-1/3 space-y-6 lg:sticky lg:top-24">
                    
                    {{-- Card: Ekspedisi (Pindahan dari Kolom Kiri) --}}
                    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-lg shadow-gray-100 border border-gray-100">
                        <h2 class="text-lg font-bold mb-6 flex items-center gap-3 text-gray-800 border-b border-gray-100 pb-4">
                            <span class="bg-purple-100 text-purple-600 w-10 h-10 flex items-center justify-center rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                            Pilih Pengiriman
                        </h2>

                        <div class="space-y-6">
                            {{-- Kurir --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kurir Ekspedisi</label>
                                <div class="relative">
                                    <select name="courier" id="courier" class="w-full border-gray-300 rounded-xl p-3.5 bg-gray-100 text-gray-500 cursor-not-allowed appearance-none" disabled required>
                                        <option value="">-- Lengkapi Alamat Di Atas --</option>
                                        <option value="jne">JNE</option>
                                        <option value="sicepat">SiCepat</option>
                                        <option value="jnt">J&T</option>
                                        <option value="idexpress">ID Express</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                        
                                    </div>
                                </div>
                            </div>

                            {{-- Type Layanan --}}
                            <div id="service_container" class="hidden animate-fade-in-down">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Layanan Pengiriman</label>
                                <select name="type" id="type" class="w-full border-fuchsia-300 rounded-xl p-3.5 focus:ring-2 focus:ring-fuchsia-200 focus:border-fuchsia-500 shadow-md text-gray-800 font-medium" required>
                                    <option value="">-- Pilih Layanan --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Card: Ringkasan Pesanan --}}
                    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-fuchsia-50/50 border border-fuchsia-100">
                        <h2 class="text-lg font-bold mb-6 text-gray-800 flex items-center justify-between">
                            Ringkasan Pesanan
                            <span class="text-xs bg-gray-100 text-gray-500 py-1 px-2 rounded-lg font-normal">{{ $cartItems->sum('quantity') }} Item</span>
                        </h2>
                        
                        {{-- List Item --}}
                        <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($cartItems as $item)
                                <div class="flex gap-4 group">
                                    <div class="w-16 h-16 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 shadow-sm group-hover:shadow-md transition">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/'.$item->product->image) }}" class="w-full h-full object-cover">
                                        @elseif($item->product->images->count() > 0)
                                            <img src="{{ asset('storage/'.$item->product->images->first()->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300 text-[10px]">No Img</div>
                                        @endif
                                    </div>

                                    <div class="flex-grow flex flex-col justify-center">
                                        <h4 class="text-sm font-bold text-gray-800 line-clamp-1 mb-1">{{ $item->product->name }}</h4>
                                        <div class="flex justify-between items-center">
                                            <span class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t-2 border-dashed border-gray-100 my-6"></div>

                        <div class="space-y-3">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal Produk</span>
                                <span class="font-bold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm items-center">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span id="shipping_display" class="text-xs font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-md">Pilih Kurir...</span>
                            </div>
                            <div id="service_detail" class="text-right text-xs text-gray-400 italic h-4"></div>
                        </div>

                        <div class="border-t border-gray-200 my-6"></div>

                        <div class="flex justify-between items-end mb-8">
                            <span class="text-gray-500 font-medium">Total Bayar</span>
                            <span id="grand_total_display" class="font-bold text-fuchsia-600 text-3xl tracking-tight">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                        
                        <button type="submit" id="btn_pay" class="w-full bg-gray-200 text-gray-400 font-bold py-4 rounded-2xl shadow-none transition-all duration-300 cursor-not-allowed flex items-center justify-center gap-2 group" disabled>
                            <span>Lengkapi Alamat</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                        
                        <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Pembayaran Aman & Terenkripsi
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Style Tambahan --}}
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #d4d4d4; }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out forwards;
        }
    </style>

    {{-- LOGIKA JAVASCRIPT --}}
    <script>
        // --- FUNCTION HELPER UNTUK ALAMAT TERSIMPAN ---
        function fillAddress(detail, postal, provId, provName, cityId, cityName, distId, distName, village) {
            // 1. Isi Text Box Manual
            // Menggunakan selector name="..." agar lebih pasti kena
            $('input[name="address_detail"]').val(detail);
            $('input[name="postal_code"]').val(postal);
            $('input[name="village_name"]').val(village); // <--- Perbaikan di sini

            // 2. Manipulasi Dropdown (Trik agar RajaOngkir membacanya)
            
            // Set Provinsi
            $('#province_id').html(`<option value="${provId}" selected>${provName}</option>`);
            $('#province_name').val(provName);

            // Set Kota
            $('#city_id').html(`<option value="${cityId}" selected>${cityName}</option>`)
                .prop('disabled', false)
                .removeClass('bg-gray-100 cursor-not-allowed');
            $('#city_name').val(cityName);

            // Set Kecamatan
            $('#district_id').html(`<option value="${distId}" selected>${distName}</option>`)
                .prop('disabled', false)
                .removeClass('bg-gray-100 cursor-not-allowed');
            $('#district_name').val(distName);

            // 3. Buka Kurir
            $('#courier').prop('disabled', false).removeClass('bg-gray-100 cursor-not-allowed');

            // Reset kalkulasi ongkir
            $('#shipping_display').text('Pilih Kurir...');
            $('#shipping_cost_input').val(0);
            $('#service_container').addClass('hidden');
        }

        // --- 2. LOGIKA UTAMA (TIDAK BERUBAH DARI CODE LAMA ANDA) ---
        $(document).ready(function() {
            let subtotal = {{ $subtotal }};
            const rupiah = (number) => new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", minimumFractionDigits: 0 }).format(number);

            // 1. Load Provinsi (Hanya jika belum dipilih via Saved Address)
            // Kita cek dulu apakah dropdown provinsi kosong (berarti user manual)
            if($('#province_id').children('option').length <= 1) {
                $.ajax({
                    url: "{{ route('api.provinces') }}", type: "GET", dataType: "json",
                    success: function(data) {
                        // Jangan timpa jika user sudah klik "Saved Address"
                        if($('#province_id').children('option').length <= 1) {
                            $('#province_id').empty().append('<option value="">-- Pilih Provinsi --</option>');
                            $.each(data, function(key, value) { $('#province_id').append(`<option value="${value.id}">${value.name}</option>`); });
                        }
                    }
                });
            }

            // 2. Load Kota
            $('#province_id').on('change', function() {
                let provinceId = $(this).val();
                $('#province_name').val($("#province_id option:selected").text());
                
                if(provinceId) {
                    $.ajax({
                        url: "/api/cities/" + provinceId, type: "GET", dataType: "json",
                        beforeSend: function() { $('#city_id').html('<option value="">Loading...</option>'); },
                        success: function(data) {
                            $('#city_id').empty().append('<option value="">-- Pilih Kota --</option>').prop('disabled', false).removeClass('bg-gray-100 cursor-not-allowed');
                            $('#district_id').empty().append('<option value="">-- Pilih Kota Dulu --</option>').prop('disabled', true).addClass('bg-gray-100 cursor-not-allowed');
                            $('#courier').prop('disabled', true).addClass('bg-gray-100 cursor-not-allowed');
                            
                            $.each(data, function(key, value) {
                                let rawZip = value.zip_code;
                                let cleanZip = "";
                                if (rawZip && rawZip !== "undefined" && rawZip !== "null") { cleanZip = rawZip; }
                                $('#city_id').append(`<option value="${value.id}" data-zip="${cleanZip}">${value.name}</option>`); 
                            });
                        }
                    });
                }
            });

            // 3. Load Kecamatan
            $('#city_id').on('change', function() {
                let cityId = $(this).val();
                $('#city_name').val($("#city_id option:selected").text());
                let zipCode = $("#city_id option:selected").attr('data-zip');
                
                if (zipCode && zipCode !== "undefined" && zipCode !== "null" && zipCode.trim() !== "") {
                    $('#postal_code').val(zipCode);
                } else {
                    $('#postal_code').val('');
                }

                if(cityId) {
                    $.ajax({
                        url: "/api/districts/" + cityId, type: "GET", dataType: "json",
                        beforeSend: function() { $('#district_id').html('<option value="">Loading...</option>'); },
                        success: function(data) {
                            $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>').prop('disabled', false).removeClass('bg-gray-100 cursor-not-allowed');
                            $('#courier').prop('disabled', true).addClass('bg-gray-100 cursor-not-allowed');
                            $.each(data, function(key, value) { $('#district_id').append(`<option value="${value.id}">${value.name}</option>`); });
                        }
                    });
                }
            });

            // 4. Buka Kurir
            $('#district_id').on('change', function() {
                $('#district_name').val($("#district_id option:selected").text());
                if($(this).val()) { $('#courier').prop('disabled', false).removeClass('bg-gray-100 cursor-not-allowed'); }
                else { $('#courier').prop('disabled', true).addClass('bg-gray-100 cursor-not-allowed'); }
            });

            // 5. Cek Ongkir
            $('#courier').on('change', function() {
                let courier = $(this).val();
                let districtId = $('#district_id').val();
                if(districtId && courier) {
                    $('#shipping_display').text('Menghitung...').removeClass('bg-orange-50 text-orange-500').addClass('text-gray-500');
                    $.ajax({
                        url: "{{ route('api.cost') }}", type: "POST",
                        data: { _token: "{{ csrf_token() }}", district_id: districtId, courier: courier, weight: 1000 },
                        dataType: "json",
                        success: function(response) {
                            $('#service_container').removeClass('hidden');
                            $('#type').empty().append('<option value="">-- Pilih Layanan --</option>');
                            $.each(response, function(key, value) {
                                $('#type').append(`<option value="${value.code}" data-cost="${value.cost}" data-desc="${value.description}">${value.name} - ${rupiah(value.cost)} (${value.description})</option>`);
                            });
                        },
                        error: function() { 
                            $('#shipping_display').text('Error').addClass('text-red-500');
                            alert('Gagal mengambil ongkir. Cek koneksi internet.'); 
                        }
                    });
                }
            });

            // 6. Pilih Layanan
            $('#type').on('change', function () {
                const selectedOption = $(this).find(':selected');
                const cost = selectedOption.data('cost');
                const desc = selectedOption.data('desc');

                if(cost) {
                    $('#shipping_display').text(rupiah(cost)).removeClass('text-gray-500').addClass('text-green-600 font-bold bg-green-50 px-2 py-1 rounded');
                    $('#service_detail').text(desc);
                    $('#shipping_cost_input').val(cost);
                    $('#grand_total_display').text(rupiah(subtotal + cost));
                    
                    $('#btn_pay').prop('disabled', false)
                        .removeClass('bg-gray-200 text-gray-400 cursor-not-allowed')
                        .addClass('bg-fuchsia-600 text-white hover:bg-fuchsia-700 hover:shadow-lg shadow-fuchsia-200 transform hover:-translate-y-1 cursor-pointer')
                        .find('span').text('Bayar Sekarang');
                }
            });
        });
    </script>
</x-app-layout>