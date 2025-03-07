<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function createRole(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|unique:roles,name',
        'guard_name' => 'web'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $role = Role::create(['name' => $request->name]);

    return response()->json([
        'success' => true,
        'message' => 'Role created successfully',
        'data' => $role
    ], 201);
}
}
