<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UpdateBookTitlesSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            1  => ['title' => 'Laskar Pelangi', 'author' => 'Andrea Hirata'],
            2  => ['title' => 'Bumi Manusia', 'author' => 'Pramoedya Ananta Toer'],
            3  => ['title' => 'Pulang', 'author' => 'Tere Liye'],
            4  => ['title' => 'Negeri 5 Menara', 'author' => 'A. Fuadi'],
            5  => ['title' => 'Saman', 'author' => 'Ayu Utami'],
            6  => ['title' => 'Perahu Kertas', 'author' => 'Dee Lestari'],
            7  => ['title' => 'Dilan 1990', 'author' => 'Pidi Baiq'],
            8  => ['title' => 'Cantik Itu Luka', 'author' => 'Eka Kurniawan'],
            9  => ['title' => 'Filosofi Teras', 'author' => 'Henry Manampiring'],
            10 => ['title' => 'Supernova: Ksatria, Puteri & Bintang Jatuh', 'author' => 'Dee Lestari'],
            11 => ['title' => 'Tenggelamnya Kapal Van der Wijck', 'author' => 'Hamka'],
            12 => ['title' => 'Sang Pemimpin', 'author' => 'Ahmad Tohari'],
            13 => ['title' => 'Ronggeng Dukuh Paruk', 'author' => 'Ahmad Tohari'],
            14 => ['title' => 'Di Bawah Lindungan Ka\'bah', 'author' => 'Hamka'],
            15 => ['title' => 'Ayah', 'author' => 'Andrea Hirata'],
            16 => ['title' => 'Sejarah Indonesia Modern', 'author' => 'M.C. Ricklefs'],
            17 => ['title' => 'Matematika Dasar SMA', 'author' => 'Marthen Kanginan'],
            18 => ['title' => 'Kimia Organik', 'author' => 'Hart & Craine'],
            19 => ['title' => 'Atlas Sejarah Indonesia', 'author' => 'Nugroho Notosusanto'],
            20 => ['title' => 'Kamus Besar Bahasa Indonesia', 'author' => 'Tim Penyusun KBBI'],
        ];

        foreach ($books as $id => $data) {
            Book::where('id', $id)->update(['title' => $data['title']]);
        }

        echo "Judul buku berhasil diperbarui!\n";
    }
}
