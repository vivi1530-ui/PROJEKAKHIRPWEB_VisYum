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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('kode_transaksi')->unique();
            $table->integer('total_harga');
            $table->enum('status', ['keranjang', 'menunggu_pembayaran', 'selesai'])->default('keranjang');
            
            // Dua kolom baru yang ditambahkan agar sinkron dengan KeranjangController
            $table->date('tanggal_ambil')->nullable();
            $table->time('jam_ambil')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};