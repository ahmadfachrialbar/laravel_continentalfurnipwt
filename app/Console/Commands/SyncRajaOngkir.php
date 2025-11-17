<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\City;
use App\Models\District;

class SyncRajaOngkir extends Command
{
    protected $signature = 'sync:rajaongkir';
    protected $description = 'Sync province, city, district data from RajaOngkir API';

    public function handle()
    {
        $apiKey = config('rajaongkir.api_key');

        // =====================================================
        // 1. SYNC PROVINCES
        // =====================================================
        $provRes = Http::withHeaders([
            'key' => $apiKey
        ])->get('https://rajaongkir.komerce.id/api/v1/destination/province');

        if (!$provRes->successful()) {
            $this->error("Failed load provinces!");
            return;
        }

        // Hapus data lama (AMAN karena tidak truncate)
        District::query()->delete();
        City::query()->delete();
        Province::query()->delete();

        foreach ($provRes['data'] as $p) {
            Province::create([
                'id' => $p['id'],
                'name' => $p['name']
            ]);
        }

        $this->info("✓ Provinces synced: " . count($provRes['data']));


        // =====================================================
        // 2. SYNC CITIES
        // =====================================================
        foreach (Province::all() as $province) {
            $cityRes = Http::withHeaders([
                'key' => $apiKey
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$province->id}");

            if (!$cityRes->successful()) {
                $this->warn("Failed load cities for province {$province->id}");
                continue;
            }

            foreach ($cityRes['data'] as $c) {
                City::create([
                    'id' => $c['id'],
                    'province_id' => $province->id,
                    'name' => $c['name']
                ]);
            }
        }

        $this->info("✓ Cities synced");


        // =====================================================
        // 3. SYNC DISTRICTS
        // =====================================================
        foreach (City::all() as $city) {
            $distRes = Http::withHeaders([
                'key' => $apiKey
            ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city->id}");

            if (!$distRes->successful()) {
                $this->warn("Failed load districts for city {$city->id}");
                continue;
            }

            foreach ($distRes['data'] as $d) {
                District::create([
                    'id' => $d['id'],
                    'city_id' => $city->id,
                    'name' => $d['name']
                ]);
            }
        }

        $this->info("✓ Districts synced");
        $this->info("✔ All data synced successfully.");
    }
}
