<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = \App\Models\Book::all();
        foreach ($books as $book) {
            for ($i = 1; $i <= 3; $i++) {
                \App\Models\BookCopy::create([
                    'book_id' => $book->id,
                    'barcode' => 'B' . str_pad($book->id, 4, '0', STR_PAD_LEFT) . '-' . $i,
                    'condition' => 'Baik',
                    'status' => 'Tersedia'
                ]);
            }
        }
    }
}
