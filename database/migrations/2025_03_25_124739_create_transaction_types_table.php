<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        DB::table('transaction_types')->insert([
            ['nama' => 'Barang Masuk', 'slug' => 'barang_masuk'],
            ['nama' => 'Barang Keluar', 'slug' => 'barang_keluar'],
            ['nama' => 'Peminjaman', 'slug' => 'peminjaman'],
            ['nama' => 'Pengembalian', 'slug' => 'pengembalian'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
