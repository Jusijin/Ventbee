<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@ventbee.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'phone' => '08123456789',
            'address' => 'Kantor Pusat',
            'gender' => 'male', // <--- HARUS HURUF KECIL SEMUA (sesuai migration)
            'birth_date' => '2000-01-01',
        ]);
    }
}