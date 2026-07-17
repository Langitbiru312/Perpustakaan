<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $members = \App\Models\Member::all();
        $books = \App\Models\Book::all();
        
        if ($members->isEmpty() || $books->isEmpty()) return;
        
        foreach ($books as $book) {
            $numReviews = rand(1, 3);
            for ($i = 0; $i < $numReviews; $i++) {
                \App\Models\BookReview::create([
                    'member_id' => $members->random()->id,
                    'book_id' => $book->id,
                    'rating' => rand(3, 5),
                    'review' => 'Buku ini sangat bagus dan informatif. ' . rand(1, 100),
                ]);
            }
        }
    }
}
