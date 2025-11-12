<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class RajaOngkirController extends Controller
{

    // AJAX: ambil provinsi
    public function getProvinces()
    {
        return Cache::remember('rajaongkir_provinces', 3600, function () {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

            if ($response->successful()) {
                return response()->json($response->json()['data'] ?? []);
            }

            // Log error untuk debugging
            Log::error('RajaOngkir API Error (Provinces): ' . $response->status() . ' - ' . $response->body());

            // Return pesan error ke frontend
            return response()->json([
                'error' => 'Gagal memuat data provinsi. API mungkin sedang down. Coba lagi nanti.',
                'status' => $response->status()
            ], 500);
        });
    }

    // AJAX: ambil kota berdasarkan provinsi
    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

        if ($response->successful()) {
            return response()->json($response->json()['data'] ?? []);
        }

        return response()->json([], 500);
    }

    // AJAX: ambil kecamatan berdasarkan kota
    public function getDistricts($cityId)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

        if ($response->successful()) {
            return response()->json($response->json()['data'] ?? []);
        }

        return response()->json([], 500);
    }

    // AJAX: hitung ongkir
    public function checkOngkir(Request $request)
    {
        $response = Http::asForm()->withHeaders([
            'Accept' => 'application/json',
            'key'    => config('rajaongkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin'      => 3855, // ID kecamatan asal, ganti sesuai kebutuhan
            'destination' => $request->input('district_id'),
            'weight'      => $request->input('weight'),
            'courier'     => $request->input('courier'),
        ]);

        if ($response->successful()) {
            return $response->json()['data'] ?? [];
        }

        return response()->json([], 500);
    }
}
