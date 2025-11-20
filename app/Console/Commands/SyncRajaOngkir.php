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
    protected $description = 'Sync province, city, district from Komerce RajaOngkir API';

    public function handle()
    {
        $apiKey = env('RAJAONGKIR_API_KEY');
        if (!$apiKey) {
            $this->error("API KEY tidak ditemukan di .env");
            return;
        }

        /* =====================================================
         * 1. CEK PROVINSI — Jika kosong, sync. Jika sudah ada, skip.
         * ===================================================== */
        if (Province::count() == 0) {
            $this->info("Mengambil data provinsi...");

            try {
                $provRes = Http::withHeaders([
                    'key'    => $apiKey,
                    'Accept' => 'application/json',
                ])->get("https://rajaongkir.komerce.id/api/v1/destination/province");

                $provinces = $provRes->successful() ? $provRes['data'] ?? [] : [];
            } catch (\Exception $e) {
                $this->error("Gagal mendapatkan data provinsi: " . $e->getMessage());
                return;
            }

            if (!empty($provinces)) {
                foreach ($provinces as $p) {
                    Province::updateOrCreate(
                        ['id' => $p['id']],
                        ['name' => $p['name']]
                    );
                }
                $this->info("✓ Provinces synced: " . count($provinces));
            } else {
                $this->warn("Tidak ada data provinsi dari API, berhenti.");
                return;
            }

        } else {
            $this->info("✓ Provinces sudah ada, skip sync provinsi.");
        }

        /* =====================================================
         * 2. CEK CITIES — Jika kosong, sync. Jika sudah ada, skip.
         * ===================================================== */
        if (City::count() == 0) {
            $this->info("Mengambil data kota...");

            foreach (Province::all() as $prov) {
                try {
                    $cityRes = Http::withHeaders([
                        'key'    => $apiKey,
                        'Accept' => 'application/json',
                    ])->get("https://rajaongkir.komerce.id/api/v1/destination/city/{$prov->id}");

                    $cities = $cityRes->successful() ? $cityRes['data'] ?? [] : [];
                } catch (\Exception $e) {
                    $this->warn("Error fetching cities for province {$prov->id}: " . $e->getMessage());
                    continue;
                }

                if (!empty($cities)) {
                    foreach ($cities as $c) {
                        City::updateOrCreate(
                            ['id' => $c['id']],
                            [
                                'province_id' => $prov->id,
                                'name'        => $c['name']
                            ]
                        );
                    }
                    $this->info("✓ Cities synced for province {$prov->id}");
                } else {
                    $this->warn("Gagal mengambil cities untuk province {$prov->id}, menggunakan data lama jika ada.");
                }
            }

        } else {
            $this->info("✓ Cities sudah ada, skip sync kota.");
        }

        /* =====================================================
         * 3. SYNC DISTRICTS — hanya untuk city yang belum punya district
         * ===================================================== */
        $this->info("Mengambil data kecamatan...");

        foreach (City::all() as $city) {

            // jika district sudah ada → SKIP
            if ($city->districts()->count() > 0) continue;

            try {
                $distRes = Http::withHeaders([
                    'key'    => $apiKey,
                    'Accept' => 'application/json',
                ])->get("https://rajaongkir.komerce.id/api/v1/destination/district/{$city->id}");

                $districts = $distRes->successful() ? $distRes['data'] ?? [] : [];

            } catch (\Exception $e) {
                $this->warn("Error fetching districts for city {$city->id}: " . $e->getMessage());
                continue;
            }

            if (!empty($districts)) {

                foreach ($districts as $d) {
                    District::updateOrCreate(
                        ['id' => $d['id']],   // ← ini sesuai struktur API
                        [
                            'city_id'  => $city->id,
                            'name'     => $d['name'],
                            'zip_code' => $d['zip_code'] ?? null
                        ]
                    );
                }

                $this->info("✓ Districts synced for city {$city->id}");

            } else {
                $this->warn("Gagal mengambil districts untuk city {$city->id}, lanjut city berikutnya.");
            }
        }

        $this->info("✔ Sync district selesai.");
    }
}
