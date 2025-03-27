<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactionTypes = TransactionType::all();
        return response()->json([
            'message' => 'Daftar transaction types berhasil diambil!',
            'data' => $transactionTypes
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:transaction_types,nama',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $transactionType = TransactionType::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return response()->json([
            'message' => 'Transaction type berhasil ditambahkan!',
            'data' => $transactionType
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transactionType = TransactionType::find($id);
        if (!$transactionType) {
            return response()->json(['message' => 'Transaction type tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Transaction type berhasil diambil!',
            'data' => $transactionType
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransactionType $transactionTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transactionType = TransactionType::find($id);

        if (!$transactionType) {
            return response()->json(['message' => 'Transaction type tidak ditemukan'], 404);
        }
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255|unique:transaction_types,nama,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $transactionType->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return response()->json([
            'message' => 'Transaction type berhasil diupdate!',
            'data' => $transactionType
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transactionType = TransactionType::find($id);

        if (!$transactionType) {
            return response()->json(['message' => 'Transaction type tidak ditemukan'], 404);
        }

        $transactionType->delete();

        return response()->json([
            'message' => 'Transaction type berhasil dihapus!',
        ], 200);
    }
}
