<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Book::create([
                'title' => $faker->sentence(3),
                'isbn' => $faker->isbn13(),
                'category_id' => rand(1, 5),
                'author_id' => rand(1, 5),
                'publisher_id' => rand(1, 5),
                'publication_year' => $faker->year(),
                'synopsis' => $faker->paragraph(),
            ]);
        }
    }
}
