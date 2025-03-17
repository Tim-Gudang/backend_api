<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{

    protected $table = 'satuans';
    protected $primaryKey = 'satuan_id';

    protected $fillable = [
        'satuan_nama',
        'satuan_slug',
        'satuan_keterangan',
        'user_id',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class, 'satuan_id', 'satuan_id');
    }
}
