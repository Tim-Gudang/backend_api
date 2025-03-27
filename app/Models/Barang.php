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
        'klasifikasi_barang',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'barang_harga',
        'barang_gambar',
        'user_id'

    ];



    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class);
    }


    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function gudangs(){
        return $this->belongsToMany(Gudang::class, 'barang_gudangs')->withPivot('stok_tersedia', 'stok_dipinjam', 'stok_maintenance');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($barang) {
            if (empty($barang->barang_kode)) {
                $barang->barang_kode = 'BRG-' . rand(100000, 999999);
            }
        });
    }
}
