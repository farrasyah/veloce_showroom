<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Buat/perbarui akun admin dan akun demo user dengan password
     * yang di-hash langsung oleh Laravel (Hash::make), supaya pasti
     * cocok saat login — aman dijalankan berkali-kali.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@veloce.id'],
            [
                'name' => 'Admin Veloce',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@veloce.id'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->command?->info('Akun admin@veloce.id (admin123) dan user@veloce.id (user123) siap dipakai.');
    }
}
