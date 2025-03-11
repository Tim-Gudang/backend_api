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
            $table->id();
            $table->foreignId('jenisbarang_id')->nullable()->constrained('jenis_barangs', 'jenisbarang_id')->nullOnDelete();
            $table->foreignId('satuan_id')->nullable()->constrained('satuans', 'satuan_id')->nullOnDelete();
            $table->foreignId('gudang_id')->nullable()->constrained('gudangs')->nullOnDelete();
            $table->enum('jenis_barang', ['sekali_pakai', 'berulang'])->nullable();
            $table->string('barang_kode')->unique();
            $table->string('barang_nama');
            $table->string('barang_slug')->unique();
            $table->decimal('barang_harga')->default(0);
            $table->string('barang_gambar')->nullable();
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
