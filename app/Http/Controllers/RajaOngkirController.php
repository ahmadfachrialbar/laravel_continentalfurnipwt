<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    // Ambil semua provinsi
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'key' => config('rajaongkir.api_key'),
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        if ($response->successful()) {
            return response()->json($response->json()['data'] ?? []);
        }

        return response()->json([], 500);
    }

    // Ambil kota berdasarkan provinsi
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

    // Ambil kecamatan berdasarkan kota
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

    // Hitung ongkir
    public function checkOngkir(Request $request)
    {
        $response = Http::asForm()->withHeaders([
            'Accept' => 'application/json',
            'key'    => config('rajaongkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin'      => 6132, // ID kecamatan Purwokerto Selatan
            'destination' => $request->input('district_id'),
            'weight'      => $request->input('weight'),
            'courier'     => $request->input('courier'),
        ]);

        if ($response->successful()) {
            return response()->json($response->json()['data'] ?? []);
        }

        return response()->json([], 500);
    }

    // View utama (kalau kamu buka langsung /ongkir)
    public function index()
    {
        return view('pages.rajaongkir.index');
    }
}
