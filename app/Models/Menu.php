<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    // Atribut yang boleh diisi secara massal (Penting untuk Aktivitas 5)
    protected $fillable = [
        'category_id',
        'kode_menu', 
        'nama_menu', 
        'harga', 
        'stok', 
        'tersedia', 
        'foto'
    ];

    /**
     * Relasi ke model Category (Satu menu punya satu kategori)
     * Aktivitas 4
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Casting tipe data agar otomatis dikonversi oleh Laravel
     */
    protected $casts = [
        'tersedia' => 'boolean',
        'harga' => 'integer', // Diubah ke integer agar mudah dihitung
    ];

    /**
     * Scope untuk memfilter jajanan yang tersedia saja
     */
    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true);
    }
}