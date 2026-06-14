<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_transaksi',
        'status',
        'total_harga',
        'tanggal_ambil', // 🟢 Tambahan kolom baru untuk tanggal pickup
        'jam_ambil'      // 🟢 Tambahan kolom baru untuk jam pickup
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }
}