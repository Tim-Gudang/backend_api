<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('satuans')->insert([
            ['satuan_nama' => 'Gulung', 'satuan_slug' => 'gulung', 'satuan_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['satuan_nama' => 'Unit', 'satuan_slug' => 'unit', 'satuan_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['satuan_nama' => 'Kg', 'satuan_slug' => 'kg', 'satuan_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['satuan_nama' => 'Gram', 'satuan_slug' => 'gram', 'satuan_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['satuan_nama' => 'Mililiter', 'satuan_slug' => 'mililiter', 'satuan_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['satuan_nama' => 'Liter', 'satuan_slug' => 'liter', 'satuan_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
