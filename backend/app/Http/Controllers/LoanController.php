<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Resources\LoanResource;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{

    public function index()
    {
        $loans = Loan::with(['member', 'book'])->get();
        return LoanResource::collection($loans);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'member_email' => 'required|email|exists:members,email',
            'book_title' => 'required|string|exists:books,title',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:loan_date',
        ]);

        // 1. Cari Member ID berdasarkan email
        $member = Member::where('email', $validatedData['member_email'])->first();

        // 2. Cari Book ID berdasarkan title
        $book = Book::where('title', $validatedData['book_title'])->first();

        // 3. Buat Peminjaman (Loan) menggunakan ID yang ditemukan
        $loan = Loan::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'loan_date' => $validatedData['loan_date'],
            'return_date' => $validatedData['return_date'] ?? null,
        ]);

        // Muat relasi agar bisa ditampilkan di resource
        $loan->load(['member', 'book']);

        // Kembalikan JSON yang sudah diformat
        return new LoanResource($loan);
    }

    public function show($id)
    {
        // Ambil satu Peminjaman, sertakan relasi
        $loan = Loan::with(['member', 'book'])->findOrFail($id);

        //LoanResource untuk memformat JSON
        return new LoanResource($loan);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        // Untuk update, kita hanya izinkan update return_date
        $validatedData = $request->validate([
            'return_date' => 'required|date|after_or_equal:loan_date',
        ]);

        $loan->update([
            'return_date' => $validatedData['return_date'],
        ]);

        // Muat relasi agar bisa ditampilkan di resource
        $loan->load(['member', 'book']);

        // Kembalikan JSON yang sudah diformat
        return new LoanResource($loan);
    }
    public function destroy($id)
    {
        Loan::destroy($id);
        return response()->json(null, 204);
    }
}
