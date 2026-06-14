<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); 
            $table->string('kode_menu')->unique();
            $table->string('nama_menu');
            // 🟢 Diubah ke integer agar sinkron dengan casting integer di Model Menu.php
            $table->integer('harga'); 
            $table->integer('stok');
            // 🟢 TAMBAHKAN KOLOM FOTO DI SINI (nullable artinya boleh kosong kalau kue tidak ada foto)
            $table->string('foto')->nullable(); 
            $table->boolean('tersedia')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};