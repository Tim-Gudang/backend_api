<?php

namespace App\Http\Controllers;

use App\Models\BarangCategory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangCategoryController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_category_barang', only: ['index', 'show']),
            new Middleware('permission:create_category_barang', only: ['store']),
            new Middleware('permission:update_category_barang', only: ['update']),
            new Middleware('permission:delete_category_barang', only: ['destroy']),
        ];
    }
    public function index()
    {
        $barangCategory = BarangCategory::all();

        return response()->json([
            'message' => 'Data Kategori barang berhasil diambil',
            'data' => $barangCategory,
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:barang_categories,name',
        ], [
            'name.required' => 'Nama kategori barang wajib diisi',
            'name.unique' => 'Nama kategori barang sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $barangCategory = BarangCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'message' => 'Kategori barang berhasil ditambahkan!',
            'data' => $barangCategory
        ], 201);
    }

    public function show($id)
    {
        $barangCategory = BarangCategory::find($id);

        if (!$barangCategory) {
            return response()->json(['message' => 'Kategori barang tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Kategori barang berhasil diambil',
            'data' => $barangCategory,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $barangCategory = BarangCategory::find($id);

        if (!$barangCategory) {
            return response()->json(['message' => 'Kategori barang tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => "required|string|max:255|unique:barang_categories,name,{$barangCategory->id}",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $barangCategory->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'message' => 'Kategori varang berhasil diubah!',
            'data' => $barangCategory
        ], 200);
    }

    public function destroy($id)
    {
        $barangCategory = BarangCategory::find($id);

        if (!$barangCategory) {
            return response()->json(['message' => 'Kategori barang tidak ditemukan'], 404);
        }

        $barangCategory->delete();

        return response()->json([
            'message' => 'Kategori barang berhasil dihapus!',
        ], 204);
    }
}
