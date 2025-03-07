<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

class PermissionController extends Controller
{
    public function togglePermission(Request $request)
{
    $request->validate([
        'role' => 'required|string',
        'permission' => 'required|string',
        'status' => 'required|boolean'
    ]);

    $role = ModelsRole::where('name', $request->role)->firstOrFail();
    $permission = Permission::where('name', $request->permission)->firstOrFail();

    if ($request->status) {
        // ini aktifkan permeesion
        $role->givePermissionTo($permission);
        return response()->json(['message' => "Permission {$request->permission} diberikan ke {$request->role}"]);
    } else {
        //ini mematikan permission
        $role->revokePermissionTo($permission);
        return response()->json(['message' => "Permission {$request->permission} dicabut dari {$request->role}"]);
    }
}
}
