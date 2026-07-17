<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            \App\Models\Author::create([
                'name' => 'Penulis ' . $i,
                'bio' => 'Biografi dari Penulis ' . $i
            ]);
        }
    }
}
