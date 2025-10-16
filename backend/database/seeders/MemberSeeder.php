<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- TAMBAHKAN BARIS INI

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kode ini mengisi data ke tabel 'members'
        DB::table('members')->insert([
            ['name' => 'Ali', 'email' => 'ali@mail.com', 'phone' => '081234567'],
            ['name' => 'Budi', 'email' => 'budi@mail.com', 'phone' => '081987654'],
        ]);
    }
}