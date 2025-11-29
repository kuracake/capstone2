<x-app-layout>
    <div class="bg-pink-50 min-h-screen py-12">
        <div class="container mx-auto px-6">
            
            <h1 class="text-3xl font-bold serif text-gray-800 mb-8">Pengiriman & Pembayaran</h1>

            <form action="{{ route('checkout.store') }}" method="POST" class="flex flex-col md:flex-row gap-8">
                @csrf
                
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

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Provinsi</label>
                                    <select name="province" id="province" class="w-full border-gray-300 rounded-xl p-3 focus:ring-fuchsia-500 focus:border-fuchsia-500" required>
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                    <input type="hidden" name="province_name" id="province_name">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kota / Kabupaten</label>
                                    <select name="city" id="city" class="w-full border-gray-300 rounded-xl p-3 bg-gray-100" disabled required>
                                        <option value="">-- Pilih Provinsi Dulu --</option>
                                    </select>
                                    <input type="hidden" name="city_name" id="city_name">
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Jalan Lengkap</label>
                                    <input type="text" name="address_detail" class="w-full border-gray-300 rounded-xl p-3 focus:ring-fuchsia-500" placeholder="Jl. Mawar No. 10, RT 01/02" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kode Pos</label>
                                    <input type="text" name="postal_code" id="postal_code" class="w-full border-gray-300 rounded-xl p-3 bg-gray-50" readonly placeholder="Otomatis">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Kurir</label>
                                <select name="courier" id="courier" class="w-full border-gray-300 rounded-xl p-3 bg-gray-100" disabled required>
                                    <option value="">-- Pilih Kurir --</option>
                                    <option value="jne">JNE</option>
                                    <option value="pos">POS Indonesia</option>
                                    <option value="tiki">TIKI</option>
                                </select>
                            </div>
                        </div>
                    </div>

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

                <div class="md:w-1/3">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 sticky top-24">
                        <h2 class="text-lg font-bold mb-4 text-gray-800 border-b pb-2">Ringkasan Belanja</h2>
                        
                        <div class="space-y-3 mb-6 max-h-60 overflow-y-auto pr-2">
                            @php $subtotal = 0; @endphp
                            @if(session('cart'))
                                @foreach(session('cart') as $id => $details)
                                    @php $subtotal += $details['price'] * $details['quantity'] @endphp
                                    <div class="flex justify-between items-center text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="bg-gray-100 px-2 py-1 rounded text-xs font-bold text-gray-600">{{ $details['quantity'] }}x</span>
                                            <span class="text-gray-600">{{ Str::limit($details['name'], 15) }}</span>
                                        </div>
                                        <span class="font-bold text-gray-800">Rp {{ number_format($details['price'] * $details['quantity']) }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="border-t border-dashed border-gray-300 my-4"></div>

                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Harga</span>
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
                        <input type="hidden" name="total_payment" id="total_payment_input" value="{{ $subtotal }}">

                        <button type="submit" id="btn-pay" class="w-full bg-gray-400 text-white font-bold py-4 rounded-xl shadow-lg transition cursor-not-allowed" disabled>
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const subtotal = {{ $subtotal ?? 0 }};
        const elProv = document.getElementById('province');
        const elCity = document.getElementById('city');
        const elCourier = document.getElementById('courier');
        const elZip = document.getElementById('postal_code');
        const displayShip = document.getElementById('shipping_display');
        const displayService = document.getElementById('service_detail');
        const displayGrand = document.getElementById('grand_total_display');
        const inputShip = document.getElementById('shipping_cost_input');
        const inputTotal = document.getElementById('total_payment_input');
        const btnPay = document.getElementById('btn-pay');

        // 1. Load Provinsi saat Buka
        fetch('/api/provinces')
            .then(res => res.json())
            .then(data => {
                data.forEach(prov => {
                    let opt = document.createElement('option');
                    opt.value = prov.id;
                    opt.text = prov.name;
                    elProv.add(opt);
                });
            });

        // 2. Saat Provinsi Dipilih -> Load Kota
        elProv.addEventListener('change', function() {
            // Reset Kota & Kurir
            elCity.innerHTML = '<option value="">-- Loading... --</option>';
            elCity.disabled = true;
            elCourier.value = "";
            elCourier.disabled = true;
            elCourier.classList.add('bg-gray-100');
            resetOngkir();

            // Simpan Nama Provinsi untuk DB
            document.getElementById('province_name').value = elProv.options[elProv.selectedIndex].text;

            if(this.value) {
                fetch(`/api/cities/${this.value}`)
                    .then(res => res.json())
                    .then(data => {
                        elCity.innerHTML = '<option value="">-- Pilih Kota --</option>';
                        data.forEach(city => {
                            let opt = document.createElement('option');
                            opt.value = city.id;
                            opt.text = city.name;
                            opt.setAttribute('data-zip', city.zip_code);
                            elCity.add(opt);
                        });
                        elCity.disabled = false;
                        elCity.classList.remove('bg-gray-100');
                    });
            }
        });

        // 3. Saat Kota Dipilih -> Buka Pilihan Kurir & Isi Kodepos
        elCity.addEventListener('change', function() {
            let selectedOpt = elCity.options[elCity.selectedIndex];
            elZip.value = selectedOpt.getAttribute('data-zip');
            
            // Simpan Nama Kota untuk DB
            document.getElementById('city_name').value = selectedOpt.text;

            if(this.value) {
                elCourier.disabled = false;
                elCourier.classList.remove('bg-gray-100');
            } else {
                elCourier.disabled = true;
            }
            resetOngkir();
        });

        // 4. Saat Kurir Dipilih -> Cek Ongkir ke Server
        elCourier.addEventListener('change', function() {
            let cityId = elCity.value;
            let courierCode = this.value;

            if(cityId && courierCode) {
                displayShip.innerText = "Menghitung...";
                
                fetch('/api/cost', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ city_id: cityId, courier: courierCode })
                })
                .then(res => res.json())
                .then(data => {
                    // Ambil layanan pertama (biasanya termurah/reguler)
                    let results = data[0].costs;
                    if(results.length > 0) {
                        let service = results[0]; // Ambil index 0 (Contoh: JNE OKE/REG)
                        let cost = service.cost[0].value;
                        let etd = service.cost[0].etd; // Estimasi hari
                        let serviceName = service.service;

                        // Update Tampilan
                        displayShip.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(cost);
                        displayShip.classList.remove('text-orange-500');
                        displayShip.classList.add('text-green-600');
                        displayService.innerText = `${courierCode.toUpperCase()} ${serviceName} (${etd} Hari)`;

                        // Update Data
                        inputShip.value = cost;
                        let total = subtotal + cost;
                        displayGrand.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(total);
                        inputTotal.value = total;

                        // Aktifkan Tombol
                        btnPay.disabled = false;
                        btnPay.classList.remove('bg-gray-400', 'cursor-not-allowed');
                        btnPay.classList.add('bg-fuchsia-600', 'hover:bg-fuchsia-700');
                    } else {
                        displayShip.innerText = "Tidak tersedia";
                    }
                });
            } else {
                resetOngkir();
            }
        });

        function resetOngkir() {
            displayShip.innerText = "Pilih Kurir...";
            displayShip.classList.add('text-orange-500');
            displayShip.classList.remove('text-green-600');
            displayService.innerText = "";
            inputShip.value = 0;
            displayGrand.innerText = "Rp " + new Intl.NumberFormat('id-ID').format(subtotal);
            btnPay.disabled = true;
            btnPay.classList.add('bg-gray-400', 'cursor-not-allowed');
            btnPay.classList.remove('bg-fuchsia-600');
        }
    </script>
</x-app-layout>