<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Yelma Rapiani',
                'email' => 'yelma.rapiani@gmail.com',
                'role' => 'Superadmin',
            ],
            [
                'name' => 'Joh Doe',
                'email' => 'admin@gmail.com',
                'role' => 'Admin',
            ],
            [
                'name' => 'Siswa Satu',
                'email' => 'siswa1@gmail.com',
                'role' => 'Anggota',
            ],
            [
                'name' => 'Siswa Dua',
                'email' => 'siswa2@gmail.com',
                'role' => 'Anggota',
            ],
            [
                'name' => 'Siswa Tiga',
                'email' => 'siswa3@gmail.com',
                'role' => 'Anggota',
            ],
            [
                'name' => 'Siswa Empat',
                'email' => 'siswa4@gmail.com',
                'role' => 'Anggota',
            ],
            [
                'name' => 'Siswa Lima',
                'email' => 'siswa5@gmail.com',
                'role' => 'Anggota',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]);
        }
    }
}
