<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SatuanController extends Controller
{
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_satuan', only: ['index', 'show']),
            new Middleware('permission:create_satuan', only: ['store']),
            new Middleware('permission:update_satuan', only: ['update']),
            new Middleware('permission:delete_satuan', only: ['destroy']),
        ];
    }
    public function index()
    {
        $satuans = Satuan::with('user')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Daftar Satuan barang berhasil diambil',
            'data' => $satuans
        ]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:255', 'unique:satuans,name'],
                'description' => ['nullable', 'string'],
                'user_id' => ['nullable', 'exists:users,id'],
            ], [
                'name.required' => 'Nama satuan barang wajib diisi.',
                'name.unique' => 'Nama satuan barang sudah digunakan.',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $validatedData = $validator->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $validatedData['user_id'] = auth()->id();

            $satuan = Satuan::create($validatedData);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Satuan barang berhasil ditambahkan!',
                'data' => $satuan
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menambah satuan barang', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            return response()->json([
                'message' => 'Satuan barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $satuan
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            return response()->json([
                'message' => 'Satuan barang tidak ditemukan'
            ], 404);
        }

        try {
            DB::beginTransaction();

            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255', "unique:satuans,name,$id,id"],
                'description' => ['nullable', 'string'],
                'user_id' => ['nullable', 'exists:users,id'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
            $validatedData = $validator->validated();
            $validatedData['slug'] = Str::slug($validatedData['name']);
            $validatedData['user_id'] = auth()->id();

            $satuan->update($validatedData);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Satuan barang berhasil diubah!',
                'data' => $satuan
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal mengubah satuan barang', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            return response()->json([
                'message' => 'Satuan barang tidak ditemukan'
            ], 404);
        }

        $satuan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Satuan barang berhasil dihapus'
        ], 200);
    }

    public function restore($id)
    {
        $satuan = Satuan::onlyTrashed()->find($id);

        if (!$satuan) {
            return response()->json([
                'error' => 'Satuan barang tidak ditemukan atau belum dihapus'
            ], 404);
        }

        $satuan->restore();

        return response()->json([
            'success' => true,
            'message' => 'Satuan barang berhasil dikembalikan'
        ], 200);
    }

    public function forceDelete($id)
    {
        $satuan = Satuan::onlyTrashed()->find($id);
        if (!$satuan) {
            return response()->json(['success' => false, 'message' => 'Satuan barang tidak ditemukan atau belum dihapus'], 404);
        }

        $satuan->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Satuan barang berhasil dihapus permanen'
        ], 200);
    }
}
