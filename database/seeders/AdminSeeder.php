<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::where('email', 'admin@ppl.com')->delete();

        User::create([
            'name' => 'AdminPPL',
            'email' => 'admin@ppl.com',
            'password' => Hash::make('adminppl'),
        ]);
    }
}
