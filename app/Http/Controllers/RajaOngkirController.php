<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class RajaOngkirController extends Controller
{
    /* =======================================================
     *  GET PROVINCES — Always return: id, name
     * =======================================================*/
    public function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

            if ($response->successful()) {
                $raw = $response->json()['data'] ?? [];

                $data = collect($raw)->map(function ($item) {
                    Province::updateOrCreate(
                        ['id' => $item['province_id']],
                        ['name' => $item['province']]
                    );
                    return [
                        'id'   => $item['province_id'],
                        'name' => $item['province'],
                    ];
                });

                return response()->json($data);
            }

        } catch (\Exception $e) {
            Log::error("Province API Error: " . $e->getMessage());
        }

        // FALLBACK DB
        $fallback = Province::select('id', 'name')->get();

        return response()->json($fallback);
    }


    /* =======================================================
     *  GET CITIES — Always return: id, name
     * =======================================================*/
    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$provinceId}");

            if ($response->successful()) {
                $raw = $response->json()['data'] ?? [];

                $data = collect($raw)->map(function ($item) use ($provinceId) {

                    City::updateOrCreate(
                        ['id' => $item['city_id']],
                        [
                            'province_id' => $provinceId,
                            'name'        => $item['city_name'],
                            'type'        => $item['type'] ?? null,
                        ]
                    );

                    return [
                        'id'   => $item['city_id'],
                        'name' => $item['city_name'],
                    ];
                });

                return response()->json($data);
            }
        } catch (\Exception $e) {
            Log::error("City API Error: " . $e->getMessage());
        }

        // FALLBACK
        $fallback = City::where('province_id', $provinceId)
            ->select('id', 'name')
            ->get();

        return response()->json($fallback);
    }


    /* =======================================================
     *  GET DISTRICTS — Always return: id, name
     * =======================================================*/
    public function getDistricts($cityId)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'key' => config('rajaongkir.api_key'),
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$cityId}");

            if ($response->successful()) {
                $raw = $response->json()['data'] ?? [];

                $data = collect($raw)->map(function ($item) use ($cityId) {

                    District::updateOrCreate(
                        ['id' => $item['subdistrict_id']],
                        [
                            'city_id' => $cityId,
                            'name'    => $item['subdistrict_name'],
                        ]
                    );

                    return [
                        'id'   => $item['subdistrict_id'],
                        'name' => $item['subdistrict_name'],
                    ];
                });

                return response()->json($data);
            }

        } catch (\Exception $e) {
            Log::error("District API Error: " . $e->getMessage());
        }

        // FALLBACK
        $fallback = District::where('city_id', $cityId)
            ->select('id', 'name')
            ->get();

        return response()->json($fallback);
    }


    /* =======================================================
     *  CHECK ONGKIR (Always API)
     * =======================================================*/
    public function checkOngkir(Request $request)
    {
        $response = Http::asForm()->withHeaders([
            'Accept' => 'application/json',
            'key'    => config('rajaongkir.api_key'),
        ])->post('https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
            'origin'      => 3855,
            'destination' => $request->district_id,
            'weight'      => $request->weight,
            'courier'     => $request->courier,
        ]);

        if ($response->successful()) {
            return $response->json()['data'] ?? [];
        }

        return response()->json([], 500);
    }
}
