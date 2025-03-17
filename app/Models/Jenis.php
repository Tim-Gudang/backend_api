<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table = 'jenis_barangs';
    protected $primaryKey = 'jenisbarang_id';

    protected $fillable = [
        'jenisbarang_nama',
        'jenisbarang_slug',
        'jenisbarang_keterangan',
        'user_id',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'jenisbarang_id', 'jenisbarang_id');
    }
}
