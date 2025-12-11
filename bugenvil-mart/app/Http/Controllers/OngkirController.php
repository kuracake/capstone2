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
            ->get($this->baseUrl . '/destination/city', [
                'province_id' => $id
            ]);

        return response()->json($response->json()['data'] ?? []);
    }

    // 3. Ambil Kecamatan (Berdasarkan ID Kota)
    public function getDistricts($id)
    {
        $response = Http::withHeaders(['key' => $this->apiKey])
            ->get($this->baseUrl . '/destination/sub-district', [
                'city_id' => $id
            ]);

        return response()->json($response->json()['data'] ?? []);
    }

    // 4. Cek Ongkir (Kecamatan ke Kecamatan)
    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders(['key' => $this->apiKey])
            ->post($this->baseUrl . '/calculate/district/domestic-cost', [
                'origin_district_id'      => env('RAJAONGKIR_ORIGIN'), // ID Kecamatan Toko (Sumbergempol)
                'destination_district_id' => $request->district_id,    // ID Kecamatan Tujuan
                'weight'                  => 1000, 
                'courier'                 => $request->courier
            ]);

        return response()->json($response->json()['data'] ?? []);
    }
}