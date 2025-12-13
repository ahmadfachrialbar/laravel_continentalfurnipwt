<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Insert admin baru
        User::create([
            'name'     => 'CustomerCFP',
            'email'    => 'cust@cfp.com',
            'password' => Hash::make('custcfp'),
        ]);
    }
}
