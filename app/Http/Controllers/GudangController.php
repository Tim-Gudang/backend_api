<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar gudang berhasil diambil',
            'data' => $gudang
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255', 'unique:gudangs,name'],
                'description' => ['nullable', 'string'],
            ], [
                'name.required' => 'Nama gudang wajib diisi.',
                'name.unique' => 'Nama gudang sudah digunakan.',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $validatedData = $validator->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);

            $gudang = Gudang::create($validatedData);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Gudang berhasil ditambahkan!',
                'data' => $gudang
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menambah gudang', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $gudang = Gudang::find($id);

        if (!$gudang) {
            return response()->json([
                'success' => false,
                'message' => 'Gudang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $gudang
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $gudang = Gudang::find($id);

        if (!$gudang) {
            return response()->json([
                'success' => false,
                'message' => 'Gudang tidak ditemukan'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $validatedData = $validator->validated();

            if (isset($validatedData['name'])) {
                $validatedData['slug'] = Str::slug($validatedData['name']);
            }

            $gudang->update($validatedData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Gudang berhasil diperbarui!',
                'data' => $gudang
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui gudang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $gudang = Gudang::find($id);

        if (!$gudang) {
            return response()->json([
                'success' => false,
                'message' => 'Gudang tidak ditemukan'
            ], 404);
        }

        $gudang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gudang berhasil dihapus!'
        ], 200);
    }

    // Mengembalikan gudang yang telah dihapus
    public function restore($id)
    {
        $gudang = Gudang::onlyTrashed()->find($id);
        if (!$gudang) {
            return response()->json(['success' => false, 'message' => 'Gudang tidak ditemukan atau belum dihapus'], 404);
        }

        $gudang->restore();

        return response()->json([
            'success' => true,
            'message' => 'Gudang berhasil dikembalikan',
            'data' => $gudang
        ], 200);
    }

    // Menghapus gudang secara permanen
    public function forceDelete($id)
    {
        $gudang = Gudang::onlyTrashed()->find($id);
        if (!$gudang) {
            return response()->json(['success' => false, 'message' => 'Gudang tidak ditemukan atau belum dihapus'], 404);
        }

        $gudang->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Gudang berhasil dihapus permanen'
        ], 200);
    }
}
