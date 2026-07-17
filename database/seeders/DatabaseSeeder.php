<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            PublisherSeeder::class,
            BookSeeder::class,
            BookCopySeeder::class,
            MemberSeeder::class,
            BorrowingSeeder::class,
            FineSeeder::class,
        ]);
    }
}
