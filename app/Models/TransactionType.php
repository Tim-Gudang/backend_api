<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionType extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'slug'];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($transactionType) {
            $transactionType->slug = Str::slug($transactionType->nama);
        });
        static::updating(function ($transactionType) {
            $transactionType->slug = Str::slug($transactionType->nama);
        });
    }
    protected function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected  $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
        'deleted_at' => 'datetime:Y-m-d H:m:s',
    ];

}
