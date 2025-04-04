<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'auth:api',
            new Middleware('permission:view_user', only: ['index', 'show']),
            new Middleware('permission:create_user', only: ['store']),
            new Middleware('permission:update_user', only: ['update']),
            new Middleware('permission:delete_user', only: ['destroy']),
        ];
    }
    // daftar pengguna
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Auth::user()
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
        $role = Role::where('name', $request->roles[0])->first();
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 400);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id
        ]);

        $user->assignRole($request->roles);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil ditambahkan',
            'data' => $user
        ], 201);
    }



    public function changePassword(Request $request)
{
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).+$/',
            'confirmed'
        ],
    ], [
        'new_password.min' => 'Password baru minimal harus 8 karakter.',
        'new_password.regex' => 'Password baru harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 simbol.',
        'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    // Periksa apakah password lama cocok
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['error' => 'Password lama salah.'], 400);
    }

    // Update password baru
    $user->update(['password' => Hash::make($request->new_password)]);

    return response()->json([
        'success' => true,
        'message' => 'Password berhasil diperbarui'
    ], 200);
}

    // update
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15|unique:users,phone_number,' . $user->id,
            'avatar' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }
        try {
            $user->update($request->except('avatar'));
            if (!empty($request->avatar)) {
                if ($user->avatar && $user->avatar !== 'default_avatar.png') {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = uploadBase64Image($request->avatar, 'img/profil');
                $user->update(['avatar' => $avatarPath]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            Log::error("Error updating user: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui profil',
                'error' => $e->getMessage()
            ], 500);
        }
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
