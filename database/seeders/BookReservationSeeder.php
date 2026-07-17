<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = \App\Models\Member::all();
        $books = \App\Models\Book::all();
        
        for ($i = 0; $i < 5; $i++) {
            \App\Models\BookReservation::create([
                'member_id' => $members[$i % $members->count()]->id,
                'book_id' => $books[$i % $books->count()]->id,
                'reservation_date' => now(),
                'expiry_date' => now()->addDays(2),
                'status' => 'Menunggu',
            ]);
        }
    }
}
