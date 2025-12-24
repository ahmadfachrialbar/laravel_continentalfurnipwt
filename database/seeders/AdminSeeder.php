<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus admin lama jika email sama
        Admin::where('email', 'admin@cfp.com')->delete();

        // Insert admin baru
        Admin::create([
            'name'     => 'AdminCFP',
            'email'    => 'admin@cfp.com',
            'password' => Hash::make('  '),
        ]);
    }
}
