<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OngkirController extends Controller
{
    // API Komerce (RajaOngkir Pro)
    private $baseUrl = 'https://rajaongkir.komerce.id/api/v1';
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('RAJAONGKIR_API_KEY');
    }

    // 1. Ambil Provinsi
    public function getProvinces()
    {
        $response = Http::withHeaders(['key' => $this->apiKey])
            ->get($this->baseUrl . '/destination/province');
        
        return response()->json($response->json()['data'] ?? []);
    }

    // 2. Ambil Kota (Berdasarkan ID Provinsi)
    public function getCities($id)
    {
        $response = Http::withHeaders(['key' => $this->apiKey])
            ->get($this->baseUrl . '/destination/city/' . $id);

        return response()->json($response->json()['data'] ?? []);
    }

    // 3. Ambil Kecamatan (Berdasarkan ID Kota)
    public function getDistricts($id)
    {
        $response = Http::withHeaders(['key' => $this->apiKey])
            ->get($this->baseUrl . '/destination/district/' . $id);

        return response()->json($response->json()['data'] ?? []);
    }

    // 4. Cek Ongkir (Kecamatan ke Kecamatan)
    public function checkOngkir(Request $request)
    {
        // --- LOGIKA HITUNG BERAT (Baru Ditambahkan) ---
        $cart = session('cart');
        $totalWeight = 0;
        
        if ($cart) {
            foreach ($cart as $item) {
                // Ambil berat per item (default 1000gr jika kosong)
                $weight = $item['weight'] ?? 1000; 
                $totalWeight += ($weight * $item['quantity']);
            }
        }

        // Berat minimal 1000gr (1kg) agar API tidak error
        if ($totalWeight <= 0) $totalWeight = 1000;
        
        $response = Http::withHeaders(headers: [
            'Accept' => 'application/json',
            'key' => $this->apiKey
        ])->withOptions(options: [
            'query' => [
                'origin' => env('RAJAONGKIR_ORIGIN'),
                'destination' => $request->input('district_id'),
                'weight'                  => $totalWeight,
                'courier'                 => $request->input('courier')
            ]
        ])->post($this->baseUrl . '/calculate/district/domestic-cost');
        // if ($response->successful()) {
            return $response->json()['data'] ?? [];
        // }
    }
}