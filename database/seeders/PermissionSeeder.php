<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

use function PHPSTORM_META\map;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage_permissions',

            'create_user',
            'update_user',
            'view_user',
            'delete_user',

            'create_role',
            'update_role',
            'view_role',
            'delete_role',

            'create_barang',
            'update_barang',
            'view_barang',
            'delete_barang',

            'create_satuan',
            'update_satuan',
            'view_satuan',
            'delete_satuan',

            'create_barang_masuk',
            'update_barang_masuk',
            'view_barang_masuk',
            'delete_barang_masuk',

            'create_barang_keluar',
            'update_barang_keluar',
            'view_barang_keluar',
            'delete_barang_keluar'

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'api']);
        }
    }
}
