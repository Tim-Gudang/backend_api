<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
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

    public function generateAndSaveQRCode($id)
    {
       // Ambil data barang berdasarkan ID
    $barang = Barang::find($id);
    if (!$barang) {
        return response()->json(['error' => 'Barang tidak ditemukan'], 404);
    }

    // Tentukan nama file dan path relatif dalam disk "public"
    $fileName = $barang->barang_kode . '.svg';
    $path = 'qr_code/' . $fileName;

    // Konten QR Code dengan label
    $qrContent = $barang->barang_kode;

    // Generate QR Code dalam format SVG
    $qrCodeContent = QrCode::format('svg')
        ->size(300)
        ->errorCorrection('H')
        ->generate($qrContent);

    // Simpan QR Code ke storage disk "public"
    Storage::disk('public')->put($path, $qrCodeContent);

    // Buat URL publik untuk file QR Code
    $qrCodeUrl = asset('storage/' . $path);

    return response()->json([
        'barang_kode' => $barang->barang_kode,
        'qr_code_url' => $qrCodeUrl
    ]);

    }

    public function generateAllQRCodes()
    {
        // Ambil semua data barang
        $barangs = Barang::all();

        // Array untuk menyimpan URL QR Code tiap barang
        $qrCodes = [];

        foreach ($barangs as $barang) {
            // Tentukan nama file dan path relatif di disk "public"
            $fileName = $barang->barang_kode . '.svg';
            $path = 'qr_code/' . $fileName;

            $qrContent = $barang->barang_kode;

            // Generate QR Code dalam format SVG (tidak memerlukan Imagick)
            $qrCodeContent = QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H')
                ->generate($qrContent);

            // Simpan QR Code ke storage disk "public"
            Storage::disk('public')->put($path, $qrCodeContent);

            // Buat URL publik untuk file QR Code
            $qrCodeUrl = asset('storage/' . $path);

            // Simpan URL ke array
            $qrCodes[] = [
                'barang_id'    => $barang->id,
                'barang_kode'  => $barang->barang_kode,
                'qr_code_url'  => $qrCodeUrl,
            ];
        }

        // Kembalikan response JSON dengan daftar QR Code
        return response()->json([
            'message' => 'QR codes generated successfully.',
            'data'    => $qrCodes,
        ]);

}

}