<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; // Wajib import Log

class OngkirController extends Controller
{
    private $baseUrl = 'https://rajaongkir.komerce.id/api/v1';

    private function getHeaders() {
        return [
            'Accept' => 'application/json',
            'key' => env('RAJAONGKIR_API_KEY') // Pastikan tidak ada spasi di .env
        ];
    }

    // Fungsi Pembantu agar tidak Crash
    private function safeRequest($method, $url, $params = []) {
        try {
            // 1. Kirim Request (Abaikan SSL agar aman di local)
            $response = Http::withoutVerifying()
                ->withHeaders($this->getHeaders());

            if ($method == 'GET') {
                $response = $response->get($url, $params);
            } else {
                $response = $response->post($url, $params);
            }

            // 2. Ambil Data JSON
            $body = $response->json();

            // 3. LOGGING (Cek storage/logs/laravel.log jika error)
            if ($response->failed() || !isset($body['data'])) {
                Log::error("API Error di URL: $url", ['response' => $body]);
                
                // Kembalikan pesan error dari API jika ada
                return response()->json([
                    'error' => true,
                    'message' => $body['meta']['message'] ?? 'Gagal mengambil data dari API',
                    'raw_response' => $body
                ], 500);
            }

            // 4. Jika Sukses, kembalikan isinya
            return response()->json($body['data']);

        } catch (\Exception $e) {
            Log::error("Koneksi Error: " . $e->getMessage());
            return response()->json(['error' => true, 'message' => $e->getMessage()], 500);
        }
    }

    public function getProvinces()
    {
        return $this->safeRequest('GET', $this->baseUrl . '/destination/province');
    }

    public function getCities(Request $request)
    {
        // Debug ID yang dikirim
        if (!$request->id) {
            return response()->json(['error' => 'ID Provinsi tidak ditemukan'], 400);
        }
        return $this->safeRequest('GET', $this->baseUrl . '/destination/city', [
            'province_id' => $request->id
        ]);
    }

    public function getDistricts(Request $request)
    {
        return $this->safeRequest('GET', $this->baseUrl . '/destination/district', [
            'city_id' => $request->id
        ]);
    }

    public function getSubdistricts(Request $request)
    {
        return $this->safeRequest('GET', $this->baseUrl . '/destination/sub-district', [
            'district_id' => $request->id
        ]);
    }

    public function checkOngkir(Request $request)
    {
        return $this->safeRequest('POST', $this->baseUrl . '/calculate/district/domestic-cost', [
            'origin_district_id'      => env('RAJAONGKIR_ORIGIN'),
            'destination_district_id' => $request->district_id,    
            'weight'                  => 1000,
            'courier'                 => $request->courier
        ]);
    }
}