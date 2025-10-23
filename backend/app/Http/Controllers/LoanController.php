<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return response()->json(Loan::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        $loan = Loan::create($request->all());
        return response()->json($loan, 201);
    }

    public function show($id)
    {
        $loan = Loan::findOrFail($id);
        return response()->json($loan, 200);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $loan->update($request->all());
        return response()->json($loan, 200);
    }

    public function destroy($id)
    {
        Loan::destroy($id);
        return response()->json(null, 204);
    }
}
