<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'jenisbarang_id',
        'satuan_id',
        'gudang_id',
        'jenis_barang',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'barang_harga',
        'barang_barcode',
        'barang_gambar',
        'user_id'
    ];
}
