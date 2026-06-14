<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Category; 
use App\Models\Pesanan;  
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware; 
use Illuminate\Routing\Controllers\Middleware;    
use Illuminate\Support\Facades\DB;                

class MenuController extends Controller implements HasMiddleware
{
    /**
     * Middleware untuk membatasi hak akses halaman khusus Owner visYum
     */
    public static function middleware(): array
    {
        return [
            new Middleware(function ($request, $next) {
                $fiturKhususOwner = [
                    'create', 'store', 'edit', 'update', 'destroy', 
                    'resetSession', 'dashboardOwner', 'pesananOwner', 'pesananProses', 'pesananSelesai'
                ];
                
                if (in_array($request->route()->getActionMethod(), $fiturKhususOwner)) {
                    if (!auth()->check()) {
                        return redirect()->route('login');
                    }
                    // Toleransi akun login owner via@owner atau via@owner.com
                    if (auth()->user()->email !== 'via@owner' && auth()->user()->email !== 'via@owner.com') {
                        abort(403, 'Akses ditolak! Halaman ini hanya untuk Owner visYum.');
                    }
                }
                return $next($request);
            }),
        ];
    }

    /**
     * Halaman Dashboard Utama Owner
     */
    public function dashboardOwner()
    {
        $stokMenipis = Menu::with('category')
            ->where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->get();

        $listPesanan = Pesanan::with(['user', 'details.menu'])
            ->whereIn('status', ['lunas', '', 'selesai'])
            ->orderBy('id', 'desc')
            ->get();

        // FIX UTAMA: Menangkap data session counter dan waktu untuk dikirim ke view dashboard
        $kunjunganWeb = session('jumlah_kunjungan', 1250); 
        $kunjungan_pertama = session('kunjungan_pertama', '-');
        $kunjungan_terakhir = session('kunjungan_terakhir', '-');

        return view('owner.dashboard', compact(
            'stokMenipis', 
            'listPesanan', 
            'kunjunganWeb', 
            'kunjungan_pertama', 
            'kunjungan_terakhir'
        ));
    }

    /**
     * Halaman Log Monitor & Manajemen Antrean Pesanan Owner (DENGAN FILTER)
     */
    public function pesananOwner(Request $request)
    {
        $statusFilter = $request->input('status_filter');
        $query = Pesanan::with(['user', 'details.menu']);

        if ($statusFilter !== null) {
            if ($statusFilter === 'belum_diproses') {
                $query->where('status', 'lunas');
            } elseif ($statusFilter === 'sedang_diproses') {
                $query->where('status', ''); 
            } elseif ($statusFilter === 'selesai') {
                $query->where('status', 'selesai');
            }
        } else {
            $query->whereIn('status', ['lunas', '', 'selesai']);
        }

        $riwayatPesanan = $query->orderBy('id', 'desc')->get();

        $totalPendapatan = DB::table('pesanans')->where('status', 'selesai')->sum('total_harga');
        $totalTransaksi = DB::table('pesanans')->where('status', 'selesai')->count();

        return view('owner.pesanan', compact('riwayatPesanan', 'totalPendapatan', 'totalTransaksi', 'statusFilter'));
    }

    /**
     * Mengubah status lunas menjadi pengerjaan dapur (string kosong "")
     */
    public function pesananProses($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        DB::table('pesanans')
            ->where('id', $id)
            ->update([
                'status' => '', 
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return redirect()->back(); 
    }

    /**
     * Mengubah status menjadi 'selesai' (Pesanan sudah diambil)
     */
    public function pesananSelesai($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        
        DB::table('pesanans')
            ->where('id', $id)
            ->update([
                'status' => 'selesai',
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return redirect()->back(); 
    }

    /**
     * Halaman Utama List Jajanan (Sisi Pembeli)
     */
    public function index()
    {
        $menus = Menu::with('category')->latest()->paginate(10); 

        // KEMBALI KE SESSION: Tambah +1 setiap kali katalog jajanan diakses
        $kunjungan = session('jumlah_kunjungan', 1250) + 1;
        session(['jumlah_kunjungan' => $kunjungan]);

        date_default_timezone_set('Asia/Jakarta');
        $waktuSekarang = date('Y-m-d H:i:s');

        if (!session()->has('kunjungan_pertama')) {
            session(['kunjungan_pertama' => $waktuSekarang]);
        }
        session(['kunjungan_terakhir' => $waktuSekarang]);

        return view('menu.index', compact('menus'));
    }

    /**
     * Halaman Form Tambah Jajanan Baru
     */
    public function create()
    {
        $categories = Category::all(); 
        return view('menu.create', compact('categories'));
    }

    /**
     * Proses Menyimpan Jajanan Baru ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu'   => 'required|string|min:3|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required', 
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
        ]);

        $menuTerakhir = Menu::orderBy('id', 'desc')->first();
        $kodeOtomatis = !$menuTerakhir ? 'VIS001' : 'VIS' . str_pad(((int) substr($menuTerakhir->kode_menu, 3)) + 1, 3, '0', STR_PAD_LEFT);

        $data = $request->only(['nama_menu', 'harga', 'stok', 'category_id']);
        $data['kode_menu'] = $kodeOtomatis; 
        $data['tersedia'] = true;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/menu'), $namaFoto);
            $data['foto'] = $namaFoto;
        }

        Menu::create($data);
        return redirect()->route('menu.index')->with('success', 'Jajanan berhasil ditambahkan dengan Kode: ' . $kodeOtomatis);
    }

    /**
     * Menampilkan Detail Jajanan
     */
    public function show($id)
    {
        $menu = Menu::with('category')->findOrFail($id);
        
        // KEMBALI KE SESSION: Klik detail jajanan juga memicu penambahan session global
        $kunjungan = session('jumlah_kunjungan', 1250) + 1;
        session(['jumlah_kunjungan' => $kunjungan]);

        date_default_timezone_set('Asia/Jakarta');
        $waktuSekarang = date('Y-m-d H:i:s');
        if (!session()->has('kunjungan_pertama')) {
            session(['kunjungan_pertama' => $waktuSekarang]);
        }
        session(['kunjungan_terakhir' => $waktuSekarang]);

        return view('menu.show', compact('menu'));
    }

    /**
     * Halaman Form Edit Jajanan
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all(); 
        
        return view('menu.edit', compact('menu', 'categories'));
    }

    /**
     * Proses Mengupdate Data Jajanan
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $request->validate([
            'nama_menu'   => 'required|string|min:3|max:255',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'category_id' => 'required', 
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama_menu', 'harga', 'stok', 'category_id']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFoto = time() . '_' . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/menu'), $namaFoto);
            $data['foto'] = $namaFoto;

            if ($menu->foto && file_exists(public_path('uploads/menu/' . $menu->foto))) {
                unlink(public_path('uploads/menu/' . $menu->foto));
            }
        }

        $menu->update($data);
        return redirect()->route('menu.index')->with('success', 'Data jajanan ' . $menu->nama_menu . ' berhasil diupdate!');
    }

    /**
     * Menghapus Jajanan
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->foto && file_exists(public_path('uploads/menu/' . $menu->foto))) {
            unlink(public_path('uploads/menu/' . $menu->foto));
        }
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Jajanan berhasil dihapus!');
    }

    /**
     * Fitur Pencarian Jajanan (Menggunakan AJAX/JSON)
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $menus = Menu::with('category')
                    ->where('nama_menu', 'LIKE', "%{$keyword}%")
                    ->orWhere('kode_menu', 'LIKE', "%{$keyword}%")
                    ->get();

        return response()->json(['success' => true, 'data' => $menus]);
    }

    /**
     * Reset Statistik Kunjungan Web
     */
    public function resetSession()
    {
        // KEMBALI KE SESSION: Kembalikan nilai session tepat ke angka default awal
        session(['jumlah_kunjungan' => 1250]);
        session()->forget(['kunjungan_pertama', 'kunjungan_terakhir']);
        
        return redirect()->route('owner.dashboard')->with('success', 'Statistik kunjungan session telah direset!');
    }
}