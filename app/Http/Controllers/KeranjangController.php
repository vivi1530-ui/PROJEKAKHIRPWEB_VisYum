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
    // 1. Masukkan item ke keranjang (VERSI PROTEKSI KUANTITAS DAN SISA STOK)
    public function tambah(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        // Menangkap kuantitas yang diinput oleh pembeli di form etalase
        $jumlahDiminta = $request->input('jumlah', 1);

        // Proteksi Awal: Cek apakah stok di database sudah habis terjual (0 atau minus)
        if ($menu->stok < 1) {
            return redirect()->back()->with('error', 'Maaf, stok jajanan ' . $menu->nama_menu . ' sudah habis!');
        }

        // Proteksi Kedua: Jika pembeli mengetik angka inputan melebihi stok di database
        if ($jumlahDiminta > $menu->stok) {
            return redirect()->back()->with('error', 'Gagal menambahkan! Kamu meminta ' . $jumlahDiminta . ' porsi, sedangkan sisa stok ' . $menu->nama_menu . ' hanya ' . $menu->stok . ' porsi.');
        }

        $pesanan = Pesanan::where('user_id', Auth::id())
            ->where('status', 'keranjang')
            ->first();

        if (!$pesanan) {
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'kode_transaksi' => 'VY-' . time() . rand(10, 99),
                'total_harga' => 0,
                'status' => 'keranjang', 
                'tanggal_ambil' => null,
                'jam_ambil' => null,
            ]);
        }

        $detail = PesananDetail::where('pesanan_id', $pesanan->id)->where('menu_id', $menu->id)->first();

        if ($detail) {
            // Proteksi Ketiga: Jika item sudah ada di kantong, total gabungan (lama + baru) tidak boleh menjebol stok asli
            if (($detail->jumlah + $jumlahDiminta) > $menu->stok) {
                return redirect()->back()->with('error', 'Gagal menambah! Di kantong belanjamu sudah ada ' . $detail->jumlah . ' porsi. Sisa stok total jajanan ' . $menu->nama_menu . ' hanya ' . $menu->stok . ' porsi.');
            }
            
            $detail->jumlah += $jumlahDiminta;
            $hargaMenu = $detail->harga_saat_ini ?? $menu->harga;
            $detail->subtotal = $detail->jumlah * $hargaMenu;
            $detail->save();
        } else {
            // Jika item benar-benar baru dimasukkan ke keranjang
            PesananDetail::create([
                'pesanan_id' => $pesanan->id,
                'menu_id' => $menu->id,
                'jumlah' => $jumlahDiminta,
                'harga_saat_ini' => $menu->harga,
                'subtotal' => $menu->harga * $jumlahDiminta
            ]);
        }

        $pesanan->total_harga = PesananDetail::where('pesanan_id', $pesanan->id)->sum('subtotal');
        $pesanan->save();

        return redirect()->route('beli.index')->with('success', $menu->nama_menu . ' berhasil dimasukkan ke kantong belanja.');
    }

    // 2. Tampilkan Halaman Daftar Keranjang
    public function index()
    {
        $menus = Menu::all();
        $pesananAktif = Pesanan::with('details.menu')
            ->where('user_id', Auth::id())
            ->where('status', 'keranjang')
            ->first();

        // Mengambil info tanggal hari ini, jam sekarang, dan set slot jam bawaan toko
        $hariIni = now()->format('Y-m-d');
        $jamSekarang = now()->format('H:i');
        $slotJam = ['09:00', '12:00', '15:00'];

        return view('keranjang.index', compact('menus', 'pesananAktif', 'hariIni', 'jamSekarang', 'slotJam'));
    }

    // 3. Hapus item dari keranjang
    public function hapus($id)
    {
        $detail = PesananDetail::findOrFail($id);
        $pesanan = Pesanan::findOrFail($detail->pesanan_id);

        $detail->delete();

        $pesanan->total_harga = PesananDetail::where('pesanan_id', $pesanan->id)->sum('subtotal');
        $pesanan->save();

        return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang.');
    }

    // 4. Kunci keranjang, lanjut ke halaman QRIS (STATUS TETAP 'keranjang')
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

        // Simpan waktu pengambilan, status dibiarkan tetap 'keranjang' agar tidak bocor ke owner/riwayat pembeli
        $pesanan->tanggal_ambil = $request->tanggal_ambil;
        $pesanan->jam_ambil = $request->jam_ambil;
        $pesanan->save();

        return redirect()->route('pembayaran', $pesanan->id);
    }

    // 5. Tampilkan halaman barcode QRIS (Mengambil data yang masih berstatus 'keranjang')
    public function pembayaran($id)
    {
        $pesanan = Pesanan::with('details.menu')
            ->where('user_id', Auth::id())
            ->where('status', 'keranjang') // Dipastikan mengikat ke status keranjang
            ->findOrFail($id);
            
        return view('keranjang.pembayaran', compact('pesanan'));
    }

    // 6. Logika potong stok & ubah status dari 'keranjang' LANGSUNG ke 'lunas'
    public function konfirmasiPembayaran($id)
    {
        // Hanya eksekusi pesanan yang statusnya masih 'keranjang'
        $pesanan = Pesanan::with('details.menu')
            ->where('status', 'keranjang')
            ->findOrFail($id);

        // Validasi stok darurat akhir sebelum uang dipotong
        foreach ($pesanan->details as $detail) {
            if ($detail->menu && $detail->menu->stok < $detail->jumlah) {
                return redirect()->route('beli.index')->with('error', 'Transaksi gagal! Stok Jajanan ' . $detail->menu->nama_menu . ' mendadak habis dibeli pelanggan lain.');
            }
        }

        // Proses pemotongan stok aktual database
        foreach ($pesanan->details as $detail) {
            if ($detail->menu) {
                $menu = $detail->menu;
                $menu->stok = max(0, $menu->stok - $detail->jumlah); 
                $menu->save();
            }
        }

        date_default_timezone_set('Asia/Jakarta');
        $waktuSekarang = date('Y-m-d H:i:s');

        // Langsung ubah status dari 'keranjang' menjadi 'lunas' di sini
        DB::table('pesanans')
            ->where('id', $id)
            ->update([
                'status' => 'lunas',
                'updated_at' => $waktuSekarang
            ]);

        return redirect()->route('pesanan.index')->with('success', 'Pembayaran Berhasil! Pesanan kamu sekarang langsung masuk ke antrean dapur Owner.');
    }

    // 7. Fitur Riwayat Pesanan Akun Pembeli (Hanya memunculkan yang bukan berstatus 'keranjang')
    public function riwayatPembeli()
    {
        $riwayat = Pesanan::with('details.menu')
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'keranjang') // Otomatis menyembunyikan transaksi gantung/setengah jalan
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('keranjang.riwayat', compact('riwayat'));
    }

    // 8. Mengubah jumlah kuantitas item (+/-) di dalam keranjang belanjaan kanan
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