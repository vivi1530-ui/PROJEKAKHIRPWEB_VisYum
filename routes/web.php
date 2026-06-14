<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\KeranjangController; 
use App\Http\Controllers\DashboardController; 
use Illuminate\Support\Facades\Route;
use App\Models\Menu;

/*
|--------------------------------------------------------------------------
| 🔓 RUTE PUBLIK (SIAPAPUN BISA AKSES, TANPA LOGIN)
|--------------------------------------------------------------------------
*/

// Halaman Utama / Landing Page VisYum (Sebelum Login)
Route::get('/', function () {
    // FIX SESSION: Menambahkan counter kunjungan saat landing page dibuka pertama kali
    $kunjungan = session('jumlah_kunjungan', 1250) + 1;
    session(['jumlah_kunjungan' => $kunjungan]);

    // FIX WAKTU: Menyisipkan catatan waktu saat landing page diakses publik
    date_default_timezone_set('Asia/Jakarta');
    $waktuSekarang = date('Y-m-d H:i:s');

    if (!session()->has('kunjungan_pertama')) {
        session(['kunjungan_pertama' => $waktuSekarang]);
    }
    session(['kunjungan_terakhir' => $waktuSekarang]);

    $menus = Menu::all(); 
    return view('welcome', compact('menus'));
})->name('welcome');

// Pencarian Real-time AJAX untuk tabel menu di halaman depan
Route::post('/menu/search', [MenuController::class, 'search'])->name('menu.search');


/*
|--------------------------------------------------------------------------
| 🔐 KELOMPOK RUTE YANG WAJIB LOGIN (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    /*
    |--------------------------------------------------------------------------
    | 🛍️ NAVIGASI UTAMA PEMBELI (Sesuai App Blade & Sistem Laravel Breeze)
    |--------------------------------------------------------------------------
    */
    
    // 1. Beranda Pembeli
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    // 2. Beli (Etalase Belanja)
    Route::get('/beli', [KeranjangController::class, 'index'])->name('beli.index');
    Route::get('/keranjang-belanja', [KeranjangController::class, 'index'])->name('keranjang.index');

    // 3. Pesanan Saya (Riwayat Pesanan 4 Kolom)
    Route::get('/pesanan', [KeranjangController::class, 'riwayatPembeli'])->name('pesanan.index');
    Route::get('/riwayat-belanja', [KeranjangController::class, 'riwayatPembeli'])->name('riwayat.pembeli');


    /*
    |--------------------------------------------------------------------------
    | 🛒 SISTEM MANIPULASI KERANJANG
    |--------------------------------------------------------------------------
    */
    Route::prefix('keranjang')->name('keranjang.')->group(function () {
        Route::post('/tambah/{id}', [KeranjangController::class, 'tambah'])->name('tambah');
        Route::post('/update-kuantitas/{id}', [KeranjangController::class, 'updateKuantitas'])->name('updateKuantitas');
        Route::delete('/hapus/{id}', [KeranjangController::class, 'hapus'])->name('hapus');
    });

    /*
    |--------------------------------------------------------------------------
    | 💳 ALUR TRANSAKSI CHECKOUT & PEMBAYARAN
    |--------------------------------------------------------------------------
    */
    Route::post('/checkout', [KeranjangController::class, 'checkout'])->name('checkout');
    Route::get('/pembayaran/{id}', [KeranjangController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/konfirmasi/{id}', [KeranjangController::class, 'konfirmasiPembayaran'])->name('pembayaran.konfirmasi');


    /*
    |--------------------------------------------------------------------------
    | 👑 KHUSUS ENVIRONMENT / OPERASIONAL OWNER (PEMILIK TOKO)
    |--------------------------------------------------------------------------
    */
    Route::prefix('owner')->name('owner.')->group(function () {
        // Halaman Utama Owner
        Route::get('/dashboard', [MenuController::class, 'dashboardOwner'])->name('dashboard');
        
        // Halaman List Antrean Pesanan & Pendapatan
        Route::get('/pesanan', [MenuController::class, 'pesananOwner'])->name('pesanan');
        
        // Mengubah status pesanan oleh Owner
        Route::post('/pesanan/{id}/proses', [MenuController::class, 'pesananProses'])->name('pesanan.proses');
        Route::post('/pesanan/{id}/selesai', [MenuController::class, 'pesananSelesai'])->name('pesanan.selesai');
    });


    /*
    |--------------------------------------------------------------------------
    | 🍳 MANAJEMEN DATA MENU (CRUD DATA - KHUSUS OWNER)
    |--------------------------------------------------------------------------
    */
    Route::post('/menu/reset-session', [MenuController::class, 'resetSession'])->name('menu.reset_session');
    Route::get('/menu/reset-session', function() { 
        return redirect()->route('owner.dashboard'); 
    });
    
    // 1. Rute index daftar menu utama
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    
    // 2. Rute CRUD otomatis (Memproses menu/create terlebih dahulu)
    Route::resource('menu', MenuController::class)->except(['index', 'show']);

    // 3. FIX POSISI: Dipindahkan ke bagian paling akhir agar pola URL '/menu/{menu}' tidak menelan URL '/menu/create'
    Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');


    /*
    |--------------------------------------------------------------------------
    | 👤 PENGATURAN AKUN & PREFERENSI TEMA
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
});

// Membawa rute otentikasi bawaan Laravel Breeze (Login, Register, Logout)
require __DIR__.'/auth.php';