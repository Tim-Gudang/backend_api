<?php

namespace App\Http\Controllers;

use App\Models\{Transaction, TransactionDetail, Barang, BarangGudang};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'transactionType', 'transactionDetails', 'transactionDetails.barang', 'transactionDetails.gudang'])
            ->select('transactions.*');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('transaction_type_id')) {
            $query->where('transaction_type_id', $request->transaction_type_id);
        }

        if ($request->filled('transaction_code')) {
            $query->where('transaction_code', 'LIKE', "%{$request->transaction_code}%");
        }

        if ($request->filled('transaction_date_start') && $request->filled('transaction_date_end')) {
            $query->whereBetween('transaction_date', [$request->transaction_date_start, $request->transaction_date_end]);
        }

        $transactions = $query->paginate(10);
        return response()->json(['response_code' => '200', 'status' => 'success', 'message' => 'Data transaksi ditemukan', 'data' => $transactions]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'transaction_type_id' => 'required|exists:transaction_types,id',
            'items' => 'required|array|min:1',
            'items.*.barang_kode' => 'required|exists:barangs,barang_kode',
            'items.*.gudang_id' => 'required|exists:gudangs,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 422);
        }

        return DB::transaction(function () use ($request) {
            $transaction = Transaction::create([
                'user_id' => $request->user_id,
                'transaction_type_id' => $request->transaction_type_id,
                'transaction_code' => 'TXN-' . strtoupper(uniqid()),
                'transaction_date' => now(),
            ]);

            $errors = [];

            foreach ($request->items as $item) {
                $barang = Barang::where('barang_kode', $item['barang_kode'])->first();

                if (!$barang) {
                    $errors[] = "Barang dengan kode {$item['barang_kode']} tidak ditemukan!";
                    continue;
                }

                $barangGudang = BarangGudang::where('barang_id', $barang->id)
                    ->where('gudang_id', $item['gudang_id'])
                    ->first();

                if (!$barangGudang) {
                    $errors[] = "Barang {$barang->nama_barang} tidak tersedia di gudang {$item['gudang_id']}!";
                    continue;
                }

                switch ($request->transaction_type_id) {
                    case 1: // Barang Masuk
                        // $barangGudang->stok_tersedia += $item['quantity'];
                        BarangGudang::where('barang_id', $barang->id)
                            ->where('gudang_id', $item['gudang_id'])
                            ->increment('stok_tersedia', $item['quantity']);

                        break;
                    case 2: // Barang Keluar
                        if ($barangGudang->stok_tersedia < $item['quantity']) {
                            $errors[] = "Stok tidak mencukupi untuk barang {$barang->nama_barang}!";
                            continue 2;
                        }
                        // $barangGudang->stok_tersedia -= $item['quantity'];
                        BarangGudang::where('barang_id', $barang->id)
                            ->where('gudang_id', $item['gudang_id'])
                            ->decrement('stok_tersedia', $item['quantity']);

                        break;
                    case 3: // Peminjaman
                        if ($barangGudang->stok_tersedia < $item['quantity']) {
                            $errors[] = "Stok tidak mencukupi untuk dipinjam ({$barang->nama_barang})!";
                            continue 2;
                        }
                        // $barangGudang->stok_tersedia -= $item['quantity'];
                        // $barangGudang->stok_dipinjam += $item['quantity'];
                        BarangGudang::where('barang_id', $barang->id)
                            ->where('gudang_id', $item['gudang_id'])
                            ->decrement('stok_tersedia', $item['quantity']);

                        BarangGudang::where('barang_id', $barang->id)
                            ->where('gudang_id', $item['gudang_id'])
                            ->increment('stok_dipinjam', $item['quantity']);

                        break;
                    case 4: // Pengembalian
                        if ($barangGudang->stok_dipinjam < $item['quantity']) {
                            $errors[] = "Jumlah barang dikembalikan lebih banyak dari yang dipinjam! ({$barang->nama_barang})";
                            continue 2;
                        }
                        // $barangGudang->stok_tersedia += $item['quantity'];
                        // $barangGudang->stok_dipinjam -= $item['quantity'];

                        BarangGudang::where('barang_id', $barang->id)
                            ->where('gudang_id', $item['gudang_id'])
                            ->increment('stok_tersedia', $item['quantity']);

                        BarangGudang::where('barang_id', $barang->id)
                            ->where('gudang_id', $item['gudang_id'])
                            ->decrement('stok_dipinjam', $item['quantity']);

                        break;
                    default:
                        $errors[] = "Tipe transaksi tidak valid!";
                        continue 2;
                }

                BarangGudang::where('barang_id', $barang->id)
                    ->where('gudang_id', $item['gudang_id'])
                    ->update([
                        'stok_tersedia' => $barangGudang->stok_tersedia,
                        'stok_dipinjam' => $barangGudang->stok_dipinjam
                    ]);

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'barang_id' => $barang->id,
                    'gudang_id' => $item['gudang_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            if (!empty($errors)) {
                return response()->json([
                    'message' => 'Beberapa barang gagal diproses!',
                    'errors' => $errors,
                    'transaction' => $transaction,
                ], 206);
            }

            return response()->json([
                'message' => 'Transaksi berhasil!',
                'data' => $transaction,
            ], 201);
        });
    }

    public function show($id)
    {
        $transaction = Transaction::with(['user', 'transactionType', 'transactionDetails', 'transactionDetails.barang', 'transactionDetails.gudang'])
            ->where('id', $id)
            ->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi dengan ID ' . $id . 'tidak ditemukan!'], 404);
        }

        return response()->json(['response_code' => '200', 'status' => 'success', 'message' => 'Data transaksi ditemukan', 'data' => $transaction]);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'transaction_type_id' => 'sometimes|exists:transaction_types,id',
            'transaction_code' => 'sometimes|string',
            'transaction_date' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input', 'errors' => $validator->errors()], 422);
        }

        $transaction->update($request->only(['user_id', 'transaction_type_id', 'transaction_code', 'transaction_date']));

        return response()->json(['message' => 'Transaksi berhasil diperbarui', 'data' => $transaction]);
    }

    public function destroy($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Hapus detail transaksi sebelum menghapus transaksi utama
        TransactionDetail::where('transaction_id', $transaction->id)->delete();
        $transaction->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus']);
    }
}
