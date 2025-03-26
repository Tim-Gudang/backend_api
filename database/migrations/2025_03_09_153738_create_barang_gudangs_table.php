<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**e
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_gudangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->foreignId('id_gudang')->constrained('gudangs',)->onDelete('cascade');
            $table->integer('stok_tersedia')->default(0);
            $table->integer('stok_dipinjam')->default(0);
            $table->integer('stok_maintenance')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_gudangs');
    }
};
