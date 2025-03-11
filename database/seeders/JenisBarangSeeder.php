<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_barangs')->insert([
            ['jenisbarang_nama' => 'Perkakas', 'jenisbarang_slug' => 'perkakas', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Fungisida', 'jenisbarang_slug' => 'fungisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Insektisida', 'jenisbarang_slug' => 'insektisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Herbisida', 'jenisbarang_slug' => 'herbisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Bakterisida', 'jenisbarang_slug' => 'bakterisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Rodentisida', 'jenisbarang_slug' => 'rodentisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Moluskisida', 'jenisbarang_slug' => 'moluskisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Nematisida', 'jenisbarang_slug' => 'nematisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Pupuk', 'jenisbarang_slug' => 'pupuk', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Bahan Bakar', 'jenisbarang_slug' => 'bahan-bakar', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Keperluan Lapangan', 'jenisbarang_slug' => 'keperluan-lapangan', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Perekat & Perata', 'jenisbarang_slug' => 'perekat-perata', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Bakterisida & Fungisida', 'jenisbarang_slug' => 'bakterisida-fungisida', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['jenisbarang_nama' => 'Zat Pengatur Tumbuh', 'jenisbarang_slug' => 'zat-pengatur-tumbuh', 'jenisbarang_keterangan' => null, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        ]);
    }
}
