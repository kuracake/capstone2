<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OngkirController extends Controller
{
    // 1. Ambil Data Provinsi
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        return $response->json()['data'];
    }

    // 2. Ambil Data Kota berdasarkan ID Provinsi
    public function getCities($province_id)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/$province_id", [
            'province' => $province_id
        ]);

         return $response->json()['data'];
    }

    // 3. Cek Ongkir (Dari Tulungagung ke Tujuan)
    public function checkOngkir(Request $request)
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin'      => env('RAJAONGKIR_ORIGIN'), // 474 (Tulungagung)
            'destination' => $request->city_id,        // Kota Tujuan Pembeli
            'weight'      => 1000,                     // Berat 1kg (bisa dinamis nanti)
            'courier'     => $request->courier         // jne, pos, atau tiki
        ]);

        return response()->json($response['rajaongkir']['results']);
    }
}