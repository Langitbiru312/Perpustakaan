<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 3 peminjaman terlambat beserta dendanya
        $members = \App\Models\Member::all();
        $copies = \App\Models\BookCopy::where('status', 'Tersedia')->take(3)->get();
        
        foreach ($copies as $i => $copy) {
            $borrowDate = now()->subDays(rand(15, 20));
            $dueDate = $borrowDate->copy()->addDays(7);
            $returnDate = $dueDate->copy()->addDays(rand(2, 5));
            $daysLate = $returnDate->startOfDay()->diffInDays($dueDate->startOfDay());
            
            $borrowing = \App\Models\Borrowing::create([
                'member_id' => $members[$i]->id,
                'book_copy_id' => $copy->id,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'return_date' => $returnDate,
                'status' => 'Terlambat',
            ]);
            
            $borrowing->fine()->create([
                'amount' => $daysLate * 1000,
                'status' => 'Belum Lunas'
            ]);
        }
    }
}
