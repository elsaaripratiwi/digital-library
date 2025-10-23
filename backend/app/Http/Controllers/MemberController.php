<?php

namespace App\Http\Controllers; // [cite: 330]

use App\Models\Member; // [cite: 331]
use Illuminate\Http\Request; // [cite: 332]

class MemberController extends Controller // [cite: 333-334]
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Member::all(), 200); // [cite: 336-337]
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([ // [cite: 340]
            'name' => 'required', // [cite: 341]
            'email' => 'required|email|unique:members', // [cite: 342]
            'phone' => 'required', // [cite: 343]
        ]);

        $member = Member::create($request->all()); // [cite: 345]
        return response()->json($member, 201); // [cite: 346]
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $member = Member::findOrFail($id); // [cite: 349]
        return response()->json($member, 200); // [cite: 350]
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id); // [cite: 353]
        $member->update($request->all()); // [cite: 354]
        return response()->json($member, 200); // [cite: 355]
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Member::destroy($id); // [cite: 358]
        return response()->json(null, 204); // [cite: 359]
    }
}
