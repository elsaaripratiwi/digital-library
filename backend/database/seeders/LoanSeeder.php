<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use App\Models\Member;
use App\Models\Book;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID yang ada dari tabel members & books
        $members = Member::pluck('id');
        $books = Book::pluck('id');

        // Cegah error jika data masih kosong
        if ($members->isEmpty() || $books->isEmpty()) {
            $this->command->info('⚠️  Gagal seeding Loan: Pastikan tabel members dan books sudah terisi.');
            return;
        }

        // Buat beberapa data pinjaman secara otomatis
        Loan::create([
            'member_id'   => $members->random(),
            'book_id'     => $books->random(),
            'loan_date'   => '2025-10-20',
            'return_date' => '2025-10-27',
        ]);

        Loan::create([
            'member_id'   => $members->random(),
            'book_id'     => $books->random(),
            'loan_date'   => '2025-10-22',
            'return_date' => null, // masih dipinjam
        ]);

        Loan::create([
            'member_id'   => $members->random(),
            'book_id'     => $books->random(),
            'loan_date'   => '2025-10-15',
            'return_date' => '2025-10-21',
        ]);
    }
}
