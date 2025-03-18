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
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('barang_kode');
            $table->string('pengecek_id');
            $table->foreignId('operator')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('bm_tanggal');
            $table->string('bm_jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
