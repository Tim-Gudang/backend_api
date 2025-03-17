<?php

namespace App\Models;

use Database\Seeders\JenisBarangSeeder;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $fillable = [
        'jenisbarang_id',
        'satuan_id',
        'jenis_barang',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'barang_harga',
        'barang_gambar',
        'user_id'

    ];



    public function jenisBarang()
    {
        return $this->belongsTo(Barang::class, 'jenisbarang_id', 'jenisbarang_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'satuan_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            if (empty($barang->barang_kode)) {
                $barang->barang_kode = 'BRG-' . rand(1000, 9999);
            }
        });

    }

}
