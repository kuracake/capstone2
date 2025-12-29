<x-app-layout>
    {{-- Load jQuery untuk RajaOngkir --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <div class="bg-gray-50 min-h-screen py-8 md:py-12">
        <div class="container mx-auto px-4 md:px-6 max-w-6xl">
            
            {{-- HEADER --}}
            <div class="mb-8 border-b border-gray-200 pb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 font-serif">Pengaturan Profil</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan alamat pengiriman Anda.</p>
                </div>
                
                @if (session('message'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- KOLOM KIRI: FORM & ALAMAT --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- 1. Info Profil --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    {{-- 2. DAFTAR ALAMAT TERSIMPAN (FITUR BARU) --}}
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <header class="mb-6">
                            <h2 class="text-lg font-medium text-gray-900">Daftar Alamat Tersimpan</h2>
                            <p class="mt-1 text-sm text-gray-600">Alamat ini akan muncul otomatis saat checkout.</p>
                        </header>

                        @if($addresses->isEmpty())
                            <p class="text-gray-400 italic text-sm">Belum ada alamat tersimpan. Lakukan checkout pertama kali untuk menyimpan alamat.</p>
                        @else
                            <div class="space-y-4">
                                @foreach($addresses as $addr)
                                <div class="border border-gray-100 rounded-lg p-4 bg-gray-50 hover:bg-white hover:shadow-md transition duration-200 flex flex-col sm:flex-row justify-between gap-4">
                                    <div class="flex-grow">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-bold text-gray-800">{{ $addr->district_name }}, {{ $addr->city_name }}</span>
                                            <span class="text-xs bg-fuchsia-100 text-fuchsia-600 px-2 py-0.5 rounded-full">{{ $addr->province_name }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-1">{{ $addr->address_detail }}</p>
                                        <p class="text-xs text-gray-500">
                                            Desa: <span class="font-semibold text-gray-700">{{ $addr->village_name ?? '-' }}</span> | 
                                            Kode Pos: {{ $addr->postal_code }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 shrink-0">
                                        {{-- Tombol Edit (Memicu Modal) --}}
                                        <button type="button" 
                                            onclick="openEditModal(
                                                '{{ $addr->id }}', 
                                                '{{ $addr->province_id }}', '{{ $addr->province_name }}',
                                                '{{ $addr->city_id }}', '{{ $addr->city_name }}',
                                                '{{ $addr->district_id }}', '{{ $addr->district_name }}',
                                                '{{ $addr->village_name }}', '{{ $addr->postal_code }}',
                                                '{{ $addr->address_detail }}'
                                            )"
                                            class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition">
                                            Edit
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        <form method="POST" action="{{ route('profile.address.destroy', $addr->id) }}" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KOLOM KANAN: KEAMANAN --}}
                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        @include('profile.partials.update-password-form')
                    </div>
                    <div class="bg-red-50 p-6 rounded-xl border border-red-100 shadow-sm">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- === MODAL EDIT ALAMAT === --}}
    <div id="editAddressModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeEditModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <form id="editAddressForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">Edit Alamat</h3>
                        
                        <div class="space-y-4">
                            {{-- Provinsi --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Provinsi</label>
                                <select name="province_id" id="modal_province_id" class="w-full border-gray-300 rounded-lg text-sm" required></select>
                                <input type="hidden" name="province_name" id="modal_province_name">
                            </div>

                            {{-- Kota --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kota/Kabupaten</label>
                                <select name="city_id" id="modal_city_id" class="w-full border-gray-300 rounded-lg text-sm bg-gray-50" required></select>
                                <input type="hidden" name="city_name" id="modal_city_name">
                            </div>

                            {{-- Kecamatan --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kecamatan</label>
                                <select name="district_id" id="modal_district_id" class="w-full border-gray-300 rounded-lg text-sm bg-gray-50" required></select>
                                <input type="hidden" name="district_name" id="modal_district_name">
                            </div>

                            {{-- Desa & Kode Pos --}}
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Desa / Kelurahan</label>
                                    <input type="text" name="village_name" id="modal_village_name" class="w-full border-gray-300 rounded-lg text-sm" placeholder="Nama Desa" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kode Pos</label>
                                    <input type="text" name="postal_code" id="modal_postal_code" class="w-full border-gray-300 rounded-lg text-sm" required>
                                </div>
                            </div>

                            {{-- Detail Jalan --}}
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Alamat Lengkap</label>
                                <textarea name="address_detail" id="modal_address_detail" rows="3" class="w-full border-gray-300 rounded-lg text-sm" placeholder="Nama Jalan, RT/RW..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-fuchsia-600 text-base font-medium text-white hover:bg-fuchsia-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button type="button" onclick="closeEditModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT UNTUK MODAL & RAJAONGKIR --}}
    <script>
        // 1. Fungsi Buka Modal & Isi Data
        function openEditModal(id, provId, provName, cityId, cityName, distId, distName, village, postal, detail) {
            // Set URL Action Form
            let url = "{{ route('profile.address.update', ':id') }}";
            url = url.replace(':id', id);
            $('#editAddressForm').attr('action', url);

            // Isi Input Text
            $('#modal_province_name').val(provName);
            $('#modal_city_name').val(cityName);
            $('#modal_district_name').val(distName);
            $('#modal_village_name').val(village === 'null' ? '' : village); // Handle null legacy data
            $('#modal_postal_code').val(postal);
            $('#modal_address_detail').val(detail);

            // Buka Modal
            $('#editAddressModal').removeClass('hidden');

            // --- LOGIKA RAJAONGKIR DI DALAM MODAL ---
            
            // A. Load Provinsi (Dan pilih otomatis)
            $.ajax({
                url: "{{ route('api.provinces') }}", type: "GET", dataType: "json",
                success: function(data) {
                    $('#modal_province_id').empty();
                    $.each(data, function(key, value) {
                        let selected = (value.id == provId) ? 'selected' : '';
                        $('#modal_province_id').append(`<option value="${value.id}" ${selected}>${value.name}</option>`);
                    });
                    
                    // Trigger load kota berdasarkan provinsi yang terpilih saat ini
                    loadCities(provId, cityId, distId);
                }
            });
        }

        // 2. Fungsi Load Kota (Dipisah agar bisa dipanggil saat Edit)
        function loadCities(provId, selectedCityId = null, selectedDistId = null) {
            if(!provId) return;
            $.ajax({
                url: "/api/cities/" + provId, type: "GET", dataType: "json",
                success: function(data) {
                    $('#modal_city_id').empty().append('<option value="">-- Pilih Kota --</option>');
                    $.each(data, function(key, value) {
                        let selected = (value.id == selectedCityId) ? 'selected' : '';
                        let zip = value.zip_code ? value.zip_code : '';
                        $('#modal_city_id').append(`<option value="${value.id}" data-zip="${zip}" ${selected}>${value.name}</option>`);
                    });
                    
                    // Jika ada kota terpilih, load kecamatan
                    if(selectedCityId) {
                        loadDistricts(selectedCityId, selectedDistId);
                    }
                }
            });
        }

        // 3. Fungsi Load Kecamatan
        function loadDistricts(cityId, selectedDistId = null) {
            if(!cityId) return;
            $.ajax({
                url: "/api/districts/" + cityId, type: "GET", dataType: "json",
                success: function(data) {
                    $('#modal_district_id').empty().append('<option value="">-- Pilih Kecamatan --</option>');
                    $.each(data, function(key, value) {
                        let selected = (value.id == selectedDistId) ? 'selected' : '';
                        $('#modal_district_id').append(`<option value="${value.id}" ${selected}>${value.name}</option>`);
                    });
                }
            });
        }

        // 4. Event Listeners (Jika User Mengubah Dropdown)
        $(document).ready(function() {
            // Ganti Provinsi -> Reset Kota & Kecamatan
            $('#modal_province_id').on('change', function() {
                let id = $(this).val();
                let name = $("#modal_province_id option:selected").text();
                $('#modal_province_name').val(name);
                loadCities(id); // Load ulang kota kosong
                $('#modal_district_id').empty().append('<option value="">-- Pilih Kota Dulu --</option>');
            });

            // Ganti Kota -> Reset Kecamatan & Isi Kode Pos
            $('#modal_city_id').on('change', function() {
                let id = $(this).val();
                let name = $("#modal_city_id option:selected").text();
                let zip = $("#modal_city_id option:selected").data('zip');
                
                $('#modal_city_name').val(name);
                if(zip) $('#modal_postal_code').val(zip);
                
                loadDistricts(id);
            });

            // Ganti Kecamatan
            $('#modal_district_id').on('change', function() {
                let name = $("#modal_district_id option:selected").text();
                $('#modal_district_name').val(name);
            });
        });

        function closeEditModal() {
            $('#editAddressModal').addClass('hidden');
        }
    </script>
</x-app-layout>