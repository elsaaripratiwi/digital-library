<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{

    public function index()
    {
        $books = Book::with(['author', 'publisher'])->get();
        return BookResource::collection($books);
    }


    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
        ]);

        // 2. Logika "Cari, atau Gagal"
        // Cari author berdasarkan nama. Jika tidak ada, kembalikan error 404.
        $author = Author::where('name', $request->input('author'))->first();
        if (!$author) {
            return response()->json(['message' => 'Author not found: ' . $request->input('author')], 404);
        }

        // Cari publisher berdasarkan nama. Jika tidak ada, kembalikan error 404.
        $publisher = Publisher::where('name', $request->input('publisher'))->first();
        if (!$publisher) {
            return response()->json(['message' => 'Publisher not found: ' . $request->input('publisher')], 404);
        }

        // 3. Jika true: Buat buku baru menggunakan ID yang ditemukan
        $book = Book::create([
            'title' => $request->input('title'),
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);

        // 4. Kembalikan respons (mengubah ID kembali jadi nama)
        return (new BookResource($book->load(['author', 'publisher'])))
                ->response()
                ->setStatusCode(201);
    }

    public function show(string $id)
    {
        $book = Book::with(['author', 'publisher'])->findOrFail($id);
        return new BookResource($book);
    }

    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        // 5. Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
        ]);

        // 6. Logika "Cari, atau Gagal" yang sama
        $author = Author::where('name', $request->input('author'))->first();
        if (!$author) {
            return response()->json(['message' => 'Author not found: ' . $request->input('author')], 404);
        }

        $publisher = Publisher::where('name', $request->input('publisher'))->first();
        if (!$publisher) {
            return response()->json(['message' => 'Publisher not found: ' . $request->input('publisher')], 404);
        }

        // 7. Jika true: Update buku menggunakan ID
        $book->update([
            'title' => $request->input('title'),
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);

        // 8. Kembalikan respons
        return new BookResource($book->load(['author', 'publisher']));
    }

    public function destroy(string $id)
    {
        Book::destroy($id);
        return response()->json(null, 204);
    }
}
