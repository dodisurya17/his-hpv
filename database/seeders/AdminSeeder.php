<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Membuat akun admin pertama. Ganti email & password ini segera
     * setelah login pertama kali lewat halaman "Kelola Admin".
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hishpv.test'],
            [
                'name' => 'Admin HIS-HPV',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
    }
}
