<?php

namespace App\Http\Controllers;

use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionTypeController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_jenis_barang', only: ['index', 'show']),
            new Middleware('permission:create_transaction_type', only: ['store']),
            new Middleware('permission:update_transaction_type', only: ['update']),
            new Middleware('permission:delete_transaction_type', only: ['destroy']),
        ];
    }
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:transaction_types,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $transactionType = TransactionType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transactionType = TransactionType::find($id);

        if (!$transactionType) {
            return response()->json(['message' => 'Transaction type tidak ditemukan'], 404);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:transaction_types,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $transactionType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
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
