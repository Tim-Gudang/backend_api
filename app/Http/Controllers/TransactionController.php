<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Barang;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use App\Models\Transaction;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_transaction', only: ['index']),
            new Middleware('permission:create_transaction', only: ['store']),
        ];
    }


    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'transactionType', 'transactionDetails.barang', 'transactionDetails.gudang']);

        if (!$request->user()->hasRole('superadmin')) {
            $query->where('user_id', $request->user()->id);
        }

        if ($request->filled('transaction_type_id')) {
            $query->where('transaction_type_id', $request->transaction_type_id);
        }

        if ($request->filled('transaction_code')) {
            $query->where('transaction_code', 'LIKE', "%{$request->transaction_code}%");
        }

        if ($request->filled(['transaction_date_start', 'transaction_date_end'])) {
            $query->whereBetween('transaction_date', [$request->transaction_date_start, $request->transaction_date_end]);
        }

        return TransactionResource::collection($query->paginate(10));
    }

    public function checkBarcode($kode)
    {
        $barang = Barang::where('barang_kode', $kode)->first();

        if ($barang) {
            return response()->json([
                'success' => true,
                'data'    => [
                    'barang_kode' => $barang->barang_kode,
                    'barang_nama' => $barang->barang_nama,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Barang tidak ditemukan',
        ], 404);
    }



}
