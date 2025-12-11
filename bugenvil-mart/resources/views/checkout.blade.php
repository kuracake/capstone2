<x-app-layout>
    {{-- Load jQuery dari CDN (Wajib untuk fitur ini) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <div class="bg-pink-50 min-h-screen py-12">
        <div class="container mx-auto px-6">
            
            <h1 class="text-3xl font-bold serif text-gray-800 mb-8">Pengiriman & Pembayaran</h1>

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col md:flex-row gap-8">
                @csrf
                
                {{-- KOLOM KIRI: Form Data --}}
                <div class="md:w-2/3 space-y-6">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-purple-100">
                        <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-gray-800">
                            <span class="bg-fuchsia-100 text-fuchsia-600 p-2 rounded-lg">📍</span>
                            Alamat Pengiriman
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Penerima</label>
                                <input type="text" class="w-full border-gray-300 rounded-xl p-3 bg-gray-50 text-gray-500" value="{{ Auth::user()->name }}" readonly>
                            </div>

                            {{-- Grid Wilayah (Provinsi & Kota) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Provinsi</label>
                                    <select name="province_id" id="province_id" class="w-full border-gray-300 rounded-xl p-3 focus:ring-fuchsia-500 focus:border-fuchsia-500" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                    <input type="hidden" name="province_name" id="province_name">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kota / Kabupaten</label>
                                    <select name="city_id" id="city_id" class="w-full border-gray-300 rounded-xl p-3 bg-gray-100" disabled required>
                                        <option value="">-- Pilih Provinsi Dulu --</option>
                                    </select>
                                    <input type="hidden" name="city_name" id="city_name">
                                </div>
                            </div>

                            {{-- Grid Wilayah (Kecamatan & Desa) --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kecamatan</label>
                                    <select name="district_id" id="district_id" class="w-full border-gray-300 rounded-xl p-3 bg-gray-100" disabled required>
                                        <option value="">-- Pilih Kota Dulu --</option>
                                    </select>
                                    <input type="hidden" name="district_name" id="district_name">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Desa / Kelurahan</label>
                                    <input type="text" name="village_name" class="w-full border-gray-300 rounded-xl p-3 focus:ring-fuchsia-500" placeholder="Contoh: Ds. Sukamaju" required>
                                </div>
                            </div>

                            {{-- Detail Jalan --}}
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Jalan / RT / RW</label>
                                    <input type="text" name="address_detail" class="w-full border-gray-300 rounded-xl p-3 focus:ring-fuchsia-500" placeholder="Jl. Mawar No. 10" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Pos</label>
                                    <input type="text" name="postal_code" id="postal_code" class="w-full border-gray-300 rounded-xl p-3 bg-gray-50" readonly placeholder="Otomatis">
                                </div>
                            </div>

                            {{-- Kurir --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kurir</label>
                                <select name="courier" id="courier" class="w-full border-gray-300 rounded-xl p-3 bg-gray-100" disabled required>
                                    <option value="">-- Pilih Kecamatan Dulu --</option>
                                    <option value="jne">JNE</option>
                                    <option value="sicepat">SiCepat</option>
                                    <option value="jnt">J&T</option>
                                    <option value="idexpress">ID Express</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-purple-100">
                        <h2 class="text-xl font-bold mb-4 text-gray-800">Transfer Bank</h2>
                        <div class="space-y-3">
                            <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-fuchsia-500 hover:bg-fuchsia-50 transition">
                                <input type="radio" name="bank" value="BCA" class="text-fuchsia-600 focus:ring-fuchsia-500" checked>
                                <span class="font-bold text-gray-800">Bank BCA</span>
                                <span class="ml-auto text-xs text-gray-500 font-mono">123-456-789</span>
                            </label>
                            <label class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-fuchsia-500 hover:bg-fuchsia-50 transition">
                                <input type="radio" name="bank" value="Mandiri" class="text-fuchsia-600 focus:ring-fuchsia-500">
                                <span class="font-bold text-gray-800">Bank Mandiri</span>
                                <span class="ml-auto text-xs text-gray-500 font-mono">987-654-321</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: Ringkasan --}}
                <div class="md:w-1/3">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">Ringkasan Belanja</h2>
                        
                        <div class="space-y-3 mb-6 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            @php $subtotal = 0; @endphp
                            @if(session('cart'))
                                @foreach(session('cart') as $details)
                                    @php $subtotal += $details['price'] * $details['quantity'] @endphp
                                    <div class="flex justify-between items-center text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold text-gray-600">{{ $details['quantity'] }}x</span>
                                            <span class="text-gray-600">{{ Str::limit($details['name'], 15) }}</span>
                                        </div>
                                        <span class="font-bold text-gray-800">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="border-t border-dashed border-gray-300 my-4"></div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Harga Barang</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                <span id="shipping_display" class="text-orange-500 font-bold">Pilih Kurir...</span>
                            </div>
                            <div id="service_detail" class="text-right text-xs text-gray-400 italic"></div>
                        </div>

                        <div class="border-t border-gray-200 my-4"></div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="font-bold text-gray-800 text-lg">Total Bayar</span>
                            <span id="grand_total_display" class="font-bold text-fuchsia-600 text-xl">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                        
                        <button type="submit" id="btn-pay" class="w-full bg-gray-400 text-white font-bold py-4 rounded-xl shadow-lg transition cursor-not-allowed" disabled>
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT jQuery (Logic SantriKoding) --}}
    <script>
        $(document).ready(function() {
            let subtotal = {{ $subtotal }};
            
            // Format Rupiah
            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR", minimumFractionDigits: 0 }).format(number);
            }

            // 1. Load Provinsi (Saat Halaman Siap)
            $.ajax({
                url: "{{ route('api.provinces') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('#province_id').empty().append('<option value="">-- Pilih Provinsi --</option>');
                    $.each(data, function(key, value) {
                        $('#province_id').append(`<option value="${value.id}">${value.name}</option>`);
                    });
                }
            });

            // 2. Pilih Provinsi -> Load Kota
            $('#province_id').on('change', function() {
                let provinceId = $(this).val();
                let provinceName = $("#province_id option:selected").text();
                $('#province_name').val(provinceName); // Simpan nama

                if(provinceId) {
                    $.ajax({
                        url: "/api/cities/" + provinceId,
                        type: "GET",
                        dataType: "json",
                        beforeSend: function() {
                            $('#city_id').html('<option value="">-- Loading... --</option>');
                        },
                        success: function(data) {
                            $('#city_id').empty().append('<option value="">-- Pilih Kota --</option>');
                            $('#city_id').prop('disabled', false).removeClass('bg-gray-100');
                            
                            // Reset bawahnya
                            $('#district_id').empty().append('<option value="">-- Pilih Kota Dulu --</option>').prop('disabled', true);
                            $('#courier').prop('disabled', true);
                            
                            $.each(data, function(key, value) {
                                $('#city_id').append(`<option value="${value.id}" data-zip="${value.zip_code}">${value.name}</option>`);
                            });
                        }
                    });
                }
            });

            // 3. Pilih Kota -> Load Kecamatan
            $('#city_id').on('change', function() {
                let cityId = $(this).val();
                let cityName = $("#city_id option:selected").text();
                let zipCode = $("#city_id option:selected").data('zip');
                
                $('#city_name').val(cityName);
                $('#postal_code').val(zipCode);

                if(cityId) {
                    $.ajax({
                        url: "/api/districts/" + cityId,
                        type: "GET",
                        dataType: "json",
                        beforeSend: function() {
                            $('#district_id').html('<option value="">-- Loading... --</option>');
                        },
                        success: function(data) {
                            $('#district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                            $('#district_id').prop('disabled', false).removeClass('bg-gray-100');
                            $('#courier').prop('disabled', true);

                            $.each(data, function(key, value) {
                                $('#district_id').append(`<option value="${value.id}">${value.name}</option>`);
                            });
                        }
                    });
                }
            });

            // 4. Pilih Kecamatan -> Buka Kurir
            $('#district_id').on('change', function() {
                let districtName = $("#district_id option:selected").text();
                $('#district_name').val(districtName);
                
                if($(this).val()) {
                    $('#courier').prop('disabled', false).removeClass('bg-gray-100');
                } else {
                    $('#courier').prop('disabled', true);
                }
            });

            // 5. Cek Ongkir (Saat Kurir Dipilih)
            $('#courier').on('change', function() {
                let courier = $(this).val();
                let districtId = $('#district_id').val();

                if(districtId && courier) {
                    $('#shipping_display').text('Menghitung...').addClass('text-orange-500');
                    
                    $.ajax({
                        url: "{{ route('api.cost') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            district_id: districtId,
                            courier: courier,
                            weight: 1000 // Default 1kg
                        },
                        dataType: "json",
                        success: function(response) {
                            if(response.length > 0 && response[0].costs.length > 0) {
                                let service = response[0].costs[0]; // Ambil layanan pertama
                                let cost = service.cost[0].value;
                                let etd = service.cost[0].etd;
                                let serviceName = service.service;

                                // Update Tampilan
                                $('#shipping_display').text(rupiah(cost)).removeClass('text-orange-500').addClass('text-green-600');
                                $('#service_detail').text(`${courier.toUpperCase()} ${serviceName} (${etd} Hari)`);
                                
                                // Update Total
                                $('#shipping_cost_input').val(cost);
                                $('#grand_total_display').text(rupiah(subtotal + cost));
                                
                                // Aktifkan Tombol
                                $('#btn-pay').prop('disabled', false).removeClass('bg-gray-400 cursor-not-allowed').addClass('bg-fuchsia-600 hover:bg-fuchsia-700');
                            } else {
                                $('#shipping_display').text('Tidak Tersedia');
                                alert("Kurir tidak mendukung rute ini.");
                            }
                        },
                        error: function() {
                            $('#shipping_display').text('Error API');
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>