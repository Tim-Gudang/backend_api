<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\QrReader;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Zxing\QrReader as ZxingQrReader;

class BarangController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_barang', only: ['index']),
            new Middleware('permission:create_barang', only: ['store']),
            new Middleware('permission:update_barang', only: ['update']),
            new Middleware('permission:delete_barang', only: ['destroy']),
        ];
    }
    public function index()
    {
        $barang = Barang::all();
        return response()->json([
            'message' => 'Daftar barang berhasil diambil!',
            'data' => $barang
        ], 200);
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'jenisbarang_id' => 'nullable|exists:jenis_barangs,jenisbarang_id',
            'satuan_id' => 'nullable|exists:satuans,satuan_id',
            'jenis_barang' => 'nullable|in:sekali_pakai,berulang',
            'barang_nama' => 'required|string|max:255|unique:barangs,barang_nama',
            'barang_harga' => 'required|numeric|min:0',
            'barang_gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'barang_nama.unique' => 'Barang dengan nama ini sudah ada di database!',
            'barang_nama.required' => 'Nama barang wajib diisi!',
            'barang_harga.required' => 'Harga barang tidak boleh kosong!',
            'barang_harga.numeric' => 'Harga barang harus berupa angka!',
            'barang_gambar.image' => 'File harus berupa gambar!',
            'barang_gambar.mimes' => 'Format gambar harus jpeg, png, atau jpg!',
            'barang_gambar.max' => 'Ukuran gambar maksimal 2MB!',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Input tidak valid!',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['barang_slug'] = Str::slug($request->barang_nama);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('barang_gambar')) {
            $data['barang_gambar'] = $request->file('barang_gambar')->store('img/barang', 'public');
        }

        $barang = Barang::create($data);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $barang
        ], 201);
    }


    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $barang->delete();
        return response()->json(['message' => 'Barang berhasil dihapus'], 200);
    }

    public function generateQRCode($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        }

        $qrCode = QrCode::format('png')->size(200)->generate($barang->barang_kode);

        return Response::make($qrCode, 200, ['Content-Type' => 'image/png']);
    }
}
