<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = \App\Models\Member::all();
        $copies = \App\Models\BookCopy::where('status', 'Tersedia')->get();

        // 5 yang sudah dikembalikan
        for ($i = 0; $i < 5; $i++) {
            $copy = $copies[$i];
            $borrowDate = now()->subDays(rand(20, 40));
            $dueDate = $borrowDate->copy()->addDays(7);
            $returnDate = $borrowDate->copy()->addDays(rand(3, 6));

            \App\Models\Borrowing::create([
                'member_id' => $members[$i % $members->count()]->id,
                'book_copy_id' => $copy->id,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'return_date' => $returnDate,
                'status' => 'Dikembalikan',
            ]);
        }

        // 5 yang masih dipinjam (ubah status eksemplar jadi Dipinjam)
        for ($i = 5; $i < 10; $i++) {
            $copy = $copies[$i];
            $borrowDate = now()->subDays(rand(1, 5));
            $dueDate = $borrowDate->copy()->addDays(7);

            \App\Models\Borrowing::create([
                'member_id' => $members[$i % $members->count()]->id,
                'book_copy_id' => $copy->id,
                'borrow_date' => $borrowDate,
                'due_date' => $dueDate,
                'return_date' => null,
                'status' => 'Dipinjam',
            ]);

            $copy->update(['status' => 'Dipinjam']);
        }
    }
}
