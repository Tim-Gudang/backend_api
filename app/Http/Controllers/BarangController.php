<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'barang_nama' => 'required|string|max:255',
            'barang_kode' => 'required|string|unique:barangs',
            'barang_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar jika ada
        $fileName = null;
        if ($request->hasFile('barang_gambar')) {
            $file = $request->file('barang_gambar');
            $fileName = time() . '_' . Str::slug($request->barang_nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/img/barang'), $fileName);
        }

        Barang::create([
            'barang_nama' => $request->barang_nama,
            'barang_kode' => $request->barang_kode,
            'barang_slug' => Str::slug($request->barang_nama),
            'barang_harga' => $request->barang_harga ?? 0,
            'barang_gambar' => $fileName,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('barangs.index')->with('success', 'Barang berhasil ditambahkan');
    }
}
