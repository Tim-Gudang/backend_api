<?php

namespace App\Http\Controllers;

use App\Models\BarangStatus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BarangStatusController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_barang_status', only: ['index', 'show']),
            new Middleware('permission:create_barang_status', only: ['store']),
            new Middleware('permission:update_barang_status', only: ['update']),
            new Middleware('permission:delete_barang_status', only: ['destroy']),
        ];
    }
    public function index()
    {
        $barangStatuses = BarangStatus::all();

        return response()->json([
            'message' => 'Data klasifikasi barang berhasil diambil',
            'data' => $barangStatuses,
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255|unique:barang_statuses,name',
        ], [
            'name.required' => 'Nama status barang wajib diisi.',
            'name.unique' => 'Nama status barang sudah digunakan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $barangStatus = BarangStatus::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'message' => 'Status barang berhasil ditambahkan!',
            'data' => $barangStatus
        ], 201);
    }

    public function show($id)
    {
        $barangStatuses = BarangStatus::find($id);

        if (!$barangStatuses) {
            return response()->json(['message' => 'Status barang tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Status barang berhasil diambil',
            'data' => $barangStatuses,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $barangStatus = BarangStatus::find($id);

        if (!$barangStatus) {
            return response()->json(['message' => 'Status barang tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => "required|string|max:255|unique:barang_statuses,name,{$barangStatus->id}",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'errors' => $validator->errors()
            ], 422);
        }

        $barangStatus->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'message' => 'Status varang berhasil diubah!',
            'data' => $barangStatus
        ], 200);
    }

    public function destroy($id)
    {
        $barangStatus = BarangStatus::find($id);

        if (!$barangStatus) {
            return response()->json(['message' => 'Status barang tidak ditemukan'], 404);
        }

        $barangStatus->delete();

        return response()->json([
            'message' => 'Status barang berhasil dihapus!',
        ], 204);
    }
}
