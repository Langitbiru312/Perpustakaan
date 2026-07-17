<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anggota = \App\Models\User::where('role', 'Anggota')->get();
        foreach ($anggota as $i => $user) {
            \App\Models\Member::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'member_code' => 'MBR-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'phone' => '0812' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                    'address' => 'Jl. Contoh No. ' . ($i + 1) . ', Kota Contoh',
                    'is_active' => true,
                ]
            );
        }
    }
}
