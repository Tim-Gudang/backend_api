<?php

namespace App\Http\Controllers;

use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisBarang = JenisBarang::with('user')->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Daftar jenis barang berhasil diambil',
            'data' => $jenisBarang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255', 'unique:jenis_barangs,name'],
                'description' => ['sometimes', 'string'],
            ], [
                'name.required' => 'Nama jenis barang wajib diisi.',
                'name.unique' => 'Nama jenis barang sudah digunakan.',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $validatedData = $validator->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $validatedData['user_id'] = auth()->id();

            $jenisBarang = JenisBarang::create($validatedData);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jenis barang berhasil ditambahkan',
                'data' => $jenisBarang
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menambah jenis barang', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisBarang $jenisBarang)
    {
        return response()->json([
            'success' => true,
            'data' => $jenisBarang
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisBarang $jenisBarang) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisBarang $jenisBarang)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $user = Auth::user();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255', "unique:jenis_barangs,name,{$jenisBarang->id},id"],
                'description' => ['nullable', 'string'],
            ], [
                'name.required' => 'Nama jenis barang wajib diisi.',
                'name.unique' => 'Nama jenis barang sudah digunakan.',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $validatedData = $validator->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $validatedData['user_id'] = auth()->id();


            $jenisBarang->update($validatedData);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jenis barang berhasil diubah',
                'data' => $jenisBarang
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal mengubah jenis barang', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jenisBarang = JenisBarang::find($id);
        if (!$jenisBarang) {
            return response()->json(['message' => 'Jenis barang tidak ditemukan'], 404);
        }

        $jenisBarang->update(['user_id' => auth()->id()]);
        $jenisBarang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis barang berhasil dihapus!'
        ], 200);
    }

    public function restore($id)
    {
        $jenisBarang = JenisBarang::onlyTrashed()->find($id);
        if (!$jenisBarang) {
            return response()->json(['error' => 'Jenis barang tidak ditemukan atau belum dihapus'], 404);
        }

        $jenisBarang->restore();
        $jenisBarang->update(['user_id' => auth()->id()]);

        return response()->json([
            'success' => true,
            'message' => 'Jenis barang berhasil dikembalikan',
            'data' => $jenisBarang
        ], 200);
    }

    public function forceDelete($id)
    {
        $jenisBarang = JenisBarang::onlyTrashed()->find($id);

        if (!$jenisBarang) {
            return response()->json(['error' => 'Jenis barang tidak ditemukan atau belum dihapus'], 404);
        }

        $jenisBarang->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Jenis barang berhasil dihapus permanen'
        ], 200);
    }
}
