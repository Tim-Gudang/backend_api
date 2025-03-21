<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Container\Attributes\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // daftar pengguna
    public function index()
    {
        $users = User::with('roles')->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna berhasil diambil',
            'data' => $users
        ], 200);
    }

    // Menambahkan pengguna
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/',
                'confirmed'
            ],
            'roles' => 'required|array|exists:roles,name'
        ], [
            'name.unique' => 'Nama sudah digunakan, silakan gunakan nama lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->roles);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil ditambahkan',
            'data' => $user
        ], 201);
    }

    // berdasar id
    public function show($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $user
        ], 200);
    }

    // update
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255|unique:users,name,' . $id,
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/',
                'confirmed'
            ],
            'roles' => 'required|array'
        ], [
            'name.unique' => 'Nama sudah digunakan, silakan gunakan nama lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user->update($request->except(['password']));
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->roles);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diperbarui',
            'data' => $user
        ], 200);
    }
    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus'
        ], 200);
    }
}
