<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Category;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $basah = Category::create(['nama_kategori' => 'Jajan Basah']);
        $kering = Category::create(['nama_kategori' => 'Jajan Kering']);

        Menu::create([
            'category_id' => $basah->id,
            'kode_menu' => 'VIS001',
            'nama_menu' => 'Donat Gula Klasik',
            'harga' => 3000,
            'stok' => 50,
            'tersedia' => true
        ]);

        Menu::create([
            'category_id' => $basah->id,
            'kode_menu' => 'VIS002',
            'nama_menu' => 'Lemper Ayam Bakar',
            'harga' => 4000,
            'stok' => 40,
            'tersedia' => true
        ]);

        Menu::create([
            'category_id' => $basah->id,
            'kode_menu' => 'VIS006',
            'nama_menu' => 'Klepon Gula Merah',
            'harga' => 5000,
            'stok' => 25,
            'tersedia' => true
        ]);

        Menu::create([
            'category_id' => $kering->id,
            'kode_menu' => 'VIS003',
            'nama_menu' => 'Pastel Sayur Renyah',
            'harga' => 3500,
            'stok' => 30,
            'tersedia' => true
        ]);

        Menu::create([
            'category_id' => $kering->id,
            'kode_menu' => 'VIS004',
            'nama_menu' => 'Kue Lapis Kanji',
            'harga' => 2500,
            'stok' => 45,
            'tersedia' => true
        ]);

        Menu::create([
            'category_id' => $kering->id,
            'kode_menu' => 'VIS005',
            'nama_menu' => 'Risoles Mayo',
            'harga' => 5000,
            'stok' => 20,
            'tersedia' => true
        ]);
    }
}