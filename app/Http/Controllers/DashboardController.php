<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Halaman Beranda / Dashboard Utama Pembeli
     */
    public function index()
    {
        // Supaya halaman berandamu lebih informatif, kita bisa ambil sedikit data rekomendasi kue
        $rekomendasi = Menu::latest()->take(3)->get();

        // Cari tahu apakah pembeli ini punya pesanan yang statusnya masih berjalan (pending/diproses/siap)
        $pesananBerjalan = Pesanan::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'diproses', 'siap'])
            ->count();

        // Langsung arahkan ke file resources/views/dashboard.blade.php yang kamu miliki
        return view('dashboard', compact('rekomendasi', 'pesananBerjalan'));
    }
}