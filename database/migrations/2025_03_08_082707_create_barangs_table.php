<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('barang_id');
            $table->string('jenisbarang_id')->nullable();
            $table->string('satuan_id')->nullable();
            $table->string('gudang_id')->nullable();
            $table->string('barang_kode');
            $table->string('barang_nama');
            $table->string('barang_slug');
            $table->string('barang_harga');
            $table->string('barang_stok');
            $table->string('barang_gambar');
            $table->string('id_user')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
