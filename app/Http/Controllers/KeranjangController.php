<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\PesananDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    /**
     * 🛒 1. MASUKKAN ITEM KE KERANJANG (VERSI AMAN LIVE DEPLOY - FIX ERROR 500)
     */
    public function tambah(Request $request, $id)
    {
        // Pengaman: Pastikan user sudah login sebelum berbelanja
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memesan kue!');
        }

        // Pengaman Darurat: Jika sistem dipanggil tanpa input Request (mencegah Error 500)
        $jumlahDiminta = 1;
        if ($request instanceof Request) {
            $jumlahDiminta = $request->input('jumlah', 1);
        }

        // Cari menu jajanan berdasarkan ID-nya
        $menu = Menu::findOrFail($id);
        
        // Proteksi Awal: Cek apakah stok di database sudah habis terjual
        if ($menu->stok < 1) {
            return redirect()->back()->with('error', 'Maaf, stok jajanan ' . $menu->nama_menu . ' sudah habis!');
        }

        // Proteksi Kedua: Jika pembeli mengetik angka inputan melebihi stok di database
        if ($jumlahDiminta > $menu->stok) {
            return redirect()->back()->with('error', 'Gagal menambahkan! Kamu meminta ' . $jumlahDiminta . ' porsi, sedangkan sisa stok ' . $menu->nama_menu . ' hanya ' . $menu->stok . ' porsi.');
        }

        // Ambil atau buat keranjang belanja untuk user yang sedang login
        $pesanan = Pesanan::where('user_id', Auth::id())
            ->where('status', 'keranjang')
            ->first();

        // FIX FIX_FILLABLE: Menggunakan pendekatan objek manual agar lolos dari jeratan Mass Assignment di Railway
        if (!$pesanan) {
            $pesanan = new Pesanan();
            $pesanan->user_id = Auth::id();
            $pesanan->kode_transaksi = 'VY-' . time() . rand(10, 99);
            $pesanan->total_harga = 0;
            $pesanan->status = 'keranjang'; 
            $pesanan->tanggal_ambil = null;
            $pesanan->jam_ambil = null;
            $pesanan->save();
        }

        $detail = PesananDetail::where('pesanan_id', $pesanan->id)->where('menu_id', $menu->id)->first();

        if ($detail) {
            // Proteksi Ketiga: Jika item sudah ada di kantong, total gabungan tidak boleh melebihi stok
            if (($detail->jumlah + $jumlahDiminta) > $menu->stok) {
                return redirect()->back()->with('error', 'Gagal menambah! Di kantong belanjamu sudah ada ' . $detail->jumlah . ' porsi. Sisa stok total jajanan ' . $menu->nama_menu . ' hanya ' . $menu->stok . ' porsi.');
            }
            
            $detail->jumlah += $jumlahDiminta;
            $hargaMenu = $detail->harga_saat_ini ?? $menu->harga;
            $detail->subtotal = $detail->jumlah * $hargaMenu;
            $detail->save();
        } else {
            // FIX DETAIL_FILLABLE: Menggunakan pendekatan objek manual juga pada detail item baru
            $detail = new PesananDetail();
            $detail->pesanan_id = $pesanan->id;
            $detail->menu_id = $menu->id;
            $detail->jumlah = $jumlahDiminta;
            $detail->harga_saat_ini = $menu->harga;
            $detail->subtotal = $menu->harga * $jumlahDiminta;
            $detail->save();
        }

        // Hitung ulang total harga pesanan secara real-time
        $pesanan->total_harga = PesananDetail::where('pesanan_id', $pesanan->id)->sum('subtotal');
        $pesanan->save();

        return redirect()->back()->with('success', $menu->nama_menu . ' berhasil dimasukkan ke kantong belanja.');
    }

    /**
     * 📋 2. TAMPILKAN HALAMAN DAFTAR KERANJANG
     */
    public function index()
    {
        $menus = Menu::all();
        $pesananAktif = Pesanan::with('details.menu')
            ->where('user_id', Auth::id())
            ->where('status', 'keranjang')
            ->first();

        $hariIni = now()->format('Y-m-d');
        $jamSekarang = now()->format('H:i');
        $slotJam = ['09:00', '12:00', '15:00'];

        return view('keranjang.index', compact('menus', 'pesananAktif', 'hariIni', 'jamSekarang', 'slotJam'));
    }

    /**
     * ❌ 3. HAPUS ITEM DARI KERANJANG
     */
    public function hapus($id)
    {
        $detail = PesananDetail::findOrFail($id);
        $pesanan = Pesanan::findOrFail($detail->pesanan_id);

        $detail->delete();

        $pesanan->total_harga = PesananDetail::where('pesanan_id', $pesanan->id)->sum('subtotal');
        $pesanan->save();

        return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang.');
    }

    /**
     * 🔒 4. KUNCI KERANJANG, LANJUT KE HALAMAN QRIS
     */
    public function checkout(Request $request)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->where('status', 'keranjang')->first();

        if (!$pesanan || PesananDetail::where('pesanan_id', $pesanan->id)->count() == 0) {
            return redirect()->back()->with('error', 'Keranjang kamu masih kosong!');
        }

        $request->validate([
            'tanggal_ambil' => 'required|date',
            'jam_ambil' => 'required',
        ]);

        $pesanan->tanggal_ambil = $request->tanggal_ambil;
        $pesanan->jam_ambil = $request->jam_ambil;
        $pesanan->save();

        return redirect()->route('pembayaran', $pesanan->id);
    }

    /**
     * 💳 5. TAMPILKAN HALAMAN BARCODE QRIS
     */
    public function pembayaran($id)
    {
        $pesanan = Pesanan::with('details.menu')
            ->where('user_id', Auth::id())
            ->where('status', 'keranjang') 
            ->findOrFail($id);
            
        return view('keranjang.pembayaran', compact('pesanan'));
    }

    /**
     * ⚡ 6. LOGIKA POTONG STOK & UBAH STATUS DARI 'KERANJANG' KE 'LUNAS'
     */
    public function konfirmasiPembayaran($id)
    {
        $pesanan = Pesanan::with('details.menu')
            ->where('status', 'keranjang')
            ->findOrFail($id);

        foreach ($pesanan->details as $detail) {
            if ($detail->menu && $detail->menu->stok < $detail->jumlah) {
                return redirect()->route('beli.index')->with('error', 'Transaksi gagal! Stok Jajanan ' . $detail->menu->nama_menu . ' mendadak habis dibeli pelanggan lain.');
            }
        }

        foreach ($pesanan->details as $detail) {
            if ($detail->menu) {
                $menu = $detail->menu;
                $menu->stok = max(0, $menu->stok - $detail->jumlah); 
                $menu->save();
            }
        }

        date_default_timezone_set('Asia/Jakarta');
        $waktuSekarang = date('Y-m-d H:i:s');

        DB::table('pesanans')
            ->where('id', $id)
            ->update([
                'status' => 'lunas',
                'updated_at' => $waktuSekarang
            ]);

        return redirect()->route('pesanan.index')->with('success', 'Pembayaran Berhasil! Pesanan kamu sekarang langsung masuk ke antrean dapur Owner.');
    }

    /**
     * 📜 7. FITUR RIWAYAT PESANAN AKUN PEMBELI
     */
    public function riwayatPembeli()
    {
        $riwayat = Pesanan::with('details.menu')
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'keranjang') 
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('keranjang.riwayat', compact('riwayat'));
    }

    /**
     * 🔄 8. MENGUBAH JUMLAH KUANTITAS ITEM (+/-) DI DALAM KERANJANG
     */
    public function updateKuantitas(Request $request, $id)
    {
        $detail = PesananDetail::with('menu')->findOrFail($id);
        $pesanan = Pesanan::findOrFail($detail->pesanan_id);
        $aksi = $request->input('aksi');

        if ($aksi === 'tambah') {
            if (($detail->jumlah + 1) > $detail->menu->stok) {
                return redirect()->back()->with('error', 'Gagal menambah! Stok Jajanan ' . $detail->menu->nama_menu . ' tidak mencukupi.');
            }
            $detail->jumlah += 1;
        } elseif ($aksi === 'kurang') {
            if ($detail->jumlah <= 1) {
                $detail->delete();
                $pesanan->total_harga = PesananDetail::where('pesanan_id', $pesanan->id)->sum('subtotal');
                $pesanan->save();
                return redirect()->back()->with('success', 'Menu jajanan berhasil dihapus dari keranjang.');
            }
            $detail->jumlah -= 1;
        }

        $hargaMenu = $detail->harga_saat_ini ?? $detail->menu->harga;
        $detail->subtotal = $detail->jumlah * $hargaMenu;
        $detail->save();

        $pesanan->total_harga = PesananDetail::where('pesanan_id', $pesanan->id)->sum('subtotal');
        $pesanan->save();

        return redirect()->back()->with('success', 'Kuantitas ' . $detail->menu->nama_menu . ' berhasil diperbarui.');
    }
}