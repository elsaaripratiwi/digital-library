<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kode ini mengisi data ke tabel 'books'
        DB::table('books')->insert([
            ['title' => 'Bumi', 'author_id' => 1, 'publisher_id' => 1],
            ['title' => 'Laskar Pelangi', 'author_id' => 2, 'publisher_id' => 2],
        ]);
    }
}