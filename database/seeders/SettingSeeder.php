<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'app_name'    => 'Perpustakaan SMA Angkasa Jaya',
            'copyright'   => 'Yelma Rapiani | 2026',
            'login_title' => 'Login Perpustakaan SMA Angkasa Jaya',
            'keywords'    => 'perpustakaan, sekolah, sma angkasa jaya, manajemen buku',
            'description' => 'Aplikasi manajemen perpustakaan sekolah SMA Angkasa Jaya.',
        ]);
    }
}
