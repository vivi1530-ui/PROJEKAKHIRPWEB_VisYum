@extends('layouts.app')

{{-- Menyuntikkan tema dashboard agar layout utama memberikan efek background blur --}}
@section('body_class', 'dashboard-theme')

@section('content')
<style>
    /* 🌟 SINKRONISASI TOTAL BACKGROUND GAMBAR DENGAN BERANDA */
    body {
        background: url('/images/bg-warung.jpg') no-repeat center center fixed !important;
        background-size: cover !important;
    }

    /* Lapisan gelap tipis di bawah kartu agar text putih selalu terbaca kontras */
    .glass-backdrop-layer {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: -1;
    }

    /* Modifikasi transparansi Glassmorphism agar persis seperti Beranda */
    .shadow-blur {
        background: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3) !important;
    }

    /* Header tabel transparan mewah */
    .custom-thead {
        background: rgba(34, 197, 94, 0.25) !important;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2) !important;
    }

    /* Animasi denyut halus untuk stok yang kritis */
    @keyframes pulse {
        0% { opacity: 0.6; }
        50% { opacity: 1; }
        100% { opacity: 0.6; }
    }
    .animate-pulse {
        animation: pulse 2s infinite;
    }
</style>

{{-- Memasang filter kaca background --}}
<div class="glass-backdrop-layer"></div>

<div class="container py-5 text-white">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success text-white" role="alert" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 bg-danger text-white" role="alert" style="border-radius: 12px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><strong>Gagal!</strong> {{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- HEADER CARD DENGAN STYLE GLASSMORPHISM --}}
    <div class="card border-0 mb-4 shadow-lg text-white shadow-blur" style="border-radius: 15px;">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h2 class="fw-bold mb-1" style="color: #4ade80; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">📋 Daftar Menu Jajanan VisYum</h2>
                <p class="text-white mb-0" style="opacity: 0.9;">
                    @auth
                        Saatnya kelola menu tokomu, <span class="fw-bold text-white">{{ Auth::user()->name }}</span>! 
                        <span class="ms-2 badge rounded-pill bg-white text-dark shadow-sm border border-light-subtle" style="font-size: 0.75rem; padding: 5px 10px;">
                            <i class="bi bi-person-badge text-success"></i> {{ Auth::user()->email }}
                        </span>
                    @else
                        Selamat datang di VisYum! Silakan login untuk mulai memesan jajanan favoritmu.
                    @endauth
                </p>
            </div>
            <div class="d-flex gap-2">
                @auth
                    @if(Auth::user()->email != 'via@owner.com')
                        <button type="button" class="btn btn-warning text-dark px-4 shadow-sm fw-bold border-0" data-bs-toggle="offcanvas" data-bs-target="#sidebarKeranjang" style="background: linear-gradient(135deg, #facc15, #eab308);">
                            <i class="bi bi-cart3"></i> Keranjang Belanja
                        </button>
                    @endif

                    @if(Auth::user()->email == 'via@owner.com')
                        <a href="{{ route('menu.create') }}" class="btn btn-success px-4 shadow-sm fw-bold border-0" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                            <i class="bi bi-plus-lg"></i> Tambah Menu
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-success px-4 shadow-sm fw-bold border-0" style="background: linear-gradient(135deg, #4ade80, #22c55e);">
                        <i class="bi bi-box-arrow-in-right"></i> Login untuk Membeli
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- KOTAK PENCARIAN REALTIME (TANPA FILTER KATEGORI) --}}
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <div class="input-group shadow-lg shadow-blur" style="border-radius: 12px; overflow: hidden;">
                <span class="input-group-text bg-transparent border-0 ps-3">
                    <i class="bi bi-search" style="color: #4ade80;"></i>
                </span>
                <input type="text" id="live-search-input" class="form-control bg-transparent text-white border-0 py-3 ps-2 placeholder-white-50 shadow-none" placeholder="Cari jajanan secara instan di sini (Ketik nama atau kode menu)...">
            </div>
        </div>
    </div>

    {{-- TABEL DATA GLASSMORPHISM THEME --}}
    <div class="card shadow-lg border-0 shadow-blur" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0"> 
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-white">
                    <thead class="custom-thead">
                        <tr>
                            <th class="ps-4 py-3 text-white" width="12%">Kode Menu</th>
                            <th width="12%" class="text-white">Foto</th> 
                            <th width="23%" class="text-white">Nama Jajanan</th>
                            <th width="15%" class="text-white">Kategori</th> 
                            <th width="13%" class="text-white">Harga Satuan</th>
                            <th width="13%" class="text-white">Status Stok</th>
                            <th width="12%" class="text-center text-white">
                                @auth
                                    {{ Auth::user()->email == 'via@owner.com' ? 'Tindakan' : 'Pesan' }}
                                @else
                                    Info
                                @endauth
                            </th>
                        </tr>
                    </thead>
                    <tbody style="border-top: none;">
                        @forelse($menus as $menu)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <td class="ps-4">
                                <span class="badge bg-transparent border text-white px-3 py-2 text-uppercase" style="border-color: rgba(74, 222, 128, 0.5) !important; background: rgba(74, 222, 128, 0.15) !important;">
                                    {{ $menu->kode_menu }}
                                </span>
                            </td>
                            
                            <td>
                                @if($menu->foto)
                                    <img src="{{ asset('uploads/menu/' . $menu->foto) }}" alt="{{ $menu->nama_menu }}" style="width: 55px; height: 55px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(255,255,255,0.2);">
                                @else
                                    <img src="https://placehold.co/55x55/22c55e/ffffff?text=No+Pic" alt="No Image" style="width: 55px; height: 55px; object-fit: cover; border-radius: 10px;">
                                @endif
                            </td>

                            <td>
                                <div class="fw-bold text-white">{{ $menu->nama_menu }}</div>
                                <small class="text-white" style="opacity: 0.6;">ID: #{{ $menu->id }}</small>
                            </td>

                            <td>
                                @if($menu->category)
                                    <span class="badge bg-white text-dark px-2.5 py-2 fw-semibold border border-light-subtle">
                                        <i class="bi bi-tag-fill me-1 text-success"></i>{{ $menu->category->nama_kategori }}
                                    </span>
                                @else
                                    <span class="text-white small" style="opacity: 0.6;"><i>Tanpa Kategori</i></span>
                                @endif
                            </td>

                            <td class="fw-bold" style="color: #67e8f9; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($menu->stok <= 0)
                                    <span class="badge bg-dark-subtle text-white border border-secondary px-2">
                                        Habis
                                    </span>
                                @elseif($menu->stok <= 5)
                                    <span class="badge bg-danger text-white border border-danger px-2 animate-pulse">
                                        <i class="bi bi-exclamation-triangle-fill"></i> Sisa {{ $menu->stok }}
                                    </span>
                                @else
                                    <span class="badge bg-success text-white border border-success px-2">
                                        {{ $menu->stok }} Pcs
                                    </span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                @auth
                                    @if(Auth::user()->email == 'via@owner.com')
                                        <div class="btn-group shadow-sm" role="group">
                                            <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-warning px-3 text-dark fw-semibold">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger px-3" 
                                                onclick="if(confirm('Hapus jajanan {{ $menu->nama_menu }}?')) { document.getElementById('delete-form-{{ $menu->id }}').submit(); }">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $menu->id }}" action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @else
                                        @if($menu->stok > 0)
                                            <form action="{{ route('keranjang.tambah', $menu->id) }}" method="POST" class="d-inline form-keranjang-aksi">
                                                @csrf
                                                <input type="hidden" name="jumlah" value="1">
                                                <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 fw-bold text-dark shadow-sm">
                                                    <i class="bi bi-cart-plus-fill"></i> Beli
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm btn-secondary rounded-pill px-3 small" disabled>Kosong</button>
                                        @endif
                                    @endif
                                @else
                                    <span class="text-white small" style="opacity: 0.6;">Silakan Login</span>
                                @endauth
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4 text-white" style="opacity: 0.7;">
                                    <i class="bi bi-box-seam display-4"></i>
                                    <p class="mt-3 fw-semibold">Belum ada menu jajanan yang terdaftar.</p>
                                    @auth
                                        @if(Auth::user()->email == 'via@owner.com')
                                            <a href="{{ route('menu.create') }}" class="btn btn-sm btn-outline-light">Mulai Tambah Data</a>
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center" id="pagination-wrapper">
        {{ $menus->links() }}
    </div>
</div>

{{-- 🛒 SIDEBAR POPUP SLIDE-OUT KERANJANG --}}
@auth
@if(Auth::user()->email != 'via@owner.com')
@php
    $pesananAktif = \App\Models\Pesanan::with('details.menu')
        ->where('user_id', Auth::id())
        ->where('status', 'keranjang')
        ->first();
@endphp

<div class="offcanvas offcanvas-end shadow-lg" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="sidebarKeranjang" aria-labelledby="sidebarKeranjangLabel" style="width: 400px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); border-left: 3px solid #22c55e;">
    <div class="offcanvas-header bg-success text-white">
        <h5 class="offcanvas-title fw-bold" id="sidebarKeranjangLabel">🛒 Keranjang Jajanan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    
    <div class="offcanvas-body d-flex flex-column justify-content-between text-dark" id="wrapper-konten-ajax-keranjang">
        <div class="overflow-auto pe-1" style="max-height: 55vh;">
            @if($pesananAktif && $pesananAktif->details->count() > 0)
                @foreach($pesananAktif->details as $detail)
                    <div class="card mb-3 border-0 shadow-sm bg-light item-keranjang-row" data-id="{{ $detail->id }}" style="border-radius: 10px;">
                        <div class="card-body p-3 d-flex align-items-center gap-3">
                            <img src="{{ $detail->menu->foto ? asset('uploads/menu/' . $detail->menu->foto) : 'https://placehold.co/50x50/22c55e/ffffff?text=Pic' }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                            
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.9rem;">{{ $detail->menu->nama_menu }}</h6>
                                
                                <div class="d-flex align-items-center gap-2 my-1">
                                    <form action="{{ route('keranjang.updateKuantitas', $detail->id) }}" method="POST" class="m-0 p-0 form-keranjang-aksi">
                                        @csrf
                                        <input type="hidden" name="aksi" value="kurang">
                                        <button type="submit" class="btn btn-outline-secondary fw-bold d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; padding: 0; font-size: 0.85rem; border-radius: 5px;">-</button>
                                    </form>

                                    <span class="fw-bold text-dark small px-1" style="min-width: 15px; text-align: center; font-size: 0.85rem;">
                                        {{ $detail->jumlah }}
                                    </span>

                                    <form action="{{ route('keranjang.updateKuantitas', $detail->id) }}" method="POST" class="m-0 p-0 form-keranjang-aksi">
                                        @csrf
                                        <input type="hidden" name="aksi" value="tambah">
                                        <button type="submit" class="btn btn-outline-success fw-bold d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; padding: 0; font-size: 0.85rem; border-radius: 5px;">+</button>
                                    </form>
                                </div>

                                <div class="text-success fw-bold small">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                            </div>
                            
                            <form action="{{ route('keranjang.hapus', $detail->id) }}" method="POST" class="form-keranjang-aksi">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0"><i class="bi bi-trash3-fill"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-cart-x display-4 text-secondary"></i>
                    <p class="mt-2 small">Keranjang masih kosong.<br>Yuk, klik tombol beli di samping!</p>
                </div>
            @endif
        </div>

        @if($pesananAktif && $pesananAktif->details->count() > 0)
            <div class="border-top pt-3 mt-3 bg-white">
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label small fw-bold text-muted mb-1">📅 Tanggal Pengambilan:</label>
                        <input type="date" name="tanggal_ambil" class="form-control form-control-sm" required min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted mb-1">⏰ Jam Pengambilan:</label>
                        <input type="time" name="jam_ambil" class="form-control form-control-sm" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 px-1">
                        <span class="fw-bold text-secondary">Total Seluruhnya:</span>
                        <span class="h5 fw-bold text-success mb-0">Rp {{ number_format($pesananAktif->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2 text-dark shadow-sm" style="background: linear-gradient(135deg, #facc15, #eab308); border: none;">
                        <i class="bi bi-bag-check-fill me-1"></i> Selesaikan Pesanan
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endif
@endauth

{{-- INLINE STYLE UNTUK CUSTOM PLACEHOLDER DAN FILTER TABLE --}}
<style>
    #live-search-input::placeholder {
        color: rgba(255, 255, 255, 0.65) !important;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.08) !important;
        transition: background-color 0.2s ease;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    const sidebarEl = document.getElementById('sidebarKeranjang');
    let bsOffcanvas = null;
    if (sidebarEl) {
        bsOffcanvas = new bootstrap.Offcanvas(sidebarEl);
    }

    document.body.addEventListener('submit', async function(e) {
        if (e.target.classList.contains('form-keranjang-aksi') || e.target.closest('#sidebarKeranjang .form-keranjang-aksi')) {
            e.preventDefault(); 
            
            const form = e.target;
            const url = form.getAttribute('action');
            const formData = new FormData(form);
            const containerUtama = document.getElementById('wrapper-konten-ajax-keranjang');
            
            if(containerUtama) containerUtama.style.opacity = '0.5';

            try {
                const response = await fetch(url, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });

                if (response.ok) {
                    const htmlHasil = await response.text();
                    const parser = new DOMParser();
                    const docBayangan = parser.parseFromString(htmlHasil, 'text/html');
                    const dataKeranjangBaru = docBayangan.getElementById('wrapper-konten-ajax-keranjang');
                    
                    if (dataKeranjangBaru && containerUtama) {
                        containerUtama.innerHTML = dataKeranjangBaru.innerHTML;
                        
                        if (bsOffcanvas && !sidebarEl.classList.contains('show')) {
                            bsOffcanvas.show();
                        }
                    }
                }
            } catch (error) {
                console.error("Gagal update data:", error);
            } finally {
                if(containerUtama) containerUtama.style.opacity = '1';
                setTimeout(() => {
                    if (bsOffcanvas && sidebarEl && !sidebarEl.classList.contains('show')) {
                        bsOffcanvas.show();
                    }
                }, 50);
            }
        }
    });

    @auth
        @if(session('success') && Auth::user()->email != 'via@owner.com')
            if(sidebarEl && bsOffcanvas) {
                bsOffcanvas.show();
            }
        @endif
    @endauth

    // --- FITUR FILTER DATA (HANYA PENCARIAN REALTIME TANPA KATEGORI) ---
    const searchInput = document.getElementById('live-search-input');
    const tableBody = document.querySelector('table tbody');
    const paginationWrapper = document.getElementById('pagination-wrapper');
    const userEmail = "@auth{{ Auth::user()->email }}@else guest @endauth"; 

    // Fungsi Utama Eksekusi Request Pencarian ke Server
    async function jalankanFilter() {
        const keyword = searchInput ? searchInput.value : '';

        // Tampilkan/Sembunyikan pagination berdasarkan kata kunci pencarian
        if (keyword.trim() !== '') {
            if(paginationWrapper) paginationWrapper.style.display = 'none';
        } else {
            if(paginationWrapper) paginationWrapper.style.display = 'flex';
        }

        try {
            const response = await fetch("/menu/search", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ 
                    keyword: keyword, 
                    category_id: 'all', // Dipaksa 'all' karena filter kategori dihapus
                    _token: "{{ csrf_token() }}" 
                })
            });

            const result = await response.json();
            
            if (result.success) {
                tableBody.innerHTML = '';

                if (result.data.length === 0) {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4 text-white" style="opacity: 0.7;">
                                    <i class="bi bi-exclamation-circle text-danger display-4"></i>
                                    <p class="mt-3 fw-semibold">Data jajanan tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>`;
                    return;
                }

                result.data.forEach(menu => {
                    const hargaFormatted = new Intl.NumberFormat('id-ID').format(menu.harga);
                    
                    let stokBadge = '';
                    if (menu.stok <= 0) {
                        stokBadge = `<span class="badge bg-dark-subtle text-white border border-secondary px-2">Habis</span>`;
                    } else if (menu.stok <= 5) {
                        stokBadge = `<span class="badge bg-danger text-white border border-danger px-2 animate-pulse">Sisa ${menu.stok}</span>`;
                    } else {
                        stokBadge = `<span class="badge bg-success text-white border border-success px-2">${menu.stok} Pcs</span>`;
                    }

                    let fotoHtml = '';
                    if (menu.foto) {
                        fotoHtml = `<img src="/uploads/menu/${menu.foto}" alt="${menu.nama_menu}" style="width: 55px; height: 55px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(255,255,255,0.2);">`;
                    } else {
                        fotoHtml = `<img src="https://placehold.co/55x55/22c55e/ffffff?text=No+Pic" alt="No Image" style="width: 55px; height: 55px; object-fit: cover; border-radius: 10px;">`;
                    }

                    let kategoriHtml = '';
                    if (menu.category) {
                        kategoriHtml = `
                            <span class="badge bg-white text-dark px-2.5 py-2 fw-semibold border border-light-subtle">
                                <i class="bi bi-tag-fill me-1 text-success"></i>${menu.category.nama_kategori}
                            </span>`;
                    } else {
                        kategoriHtml = `<span class="text-white small" style="opacity: 0.6;"><i>Tanpa Kategori</i></span>`;
                    }

                    let actionColumnHtml = '';
                    if (userEmail === 'via@owner.com') {
                        actionColumnHtml = `
                            <td class="text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <a href="/menu/${menu.id}/edit" class="btn btn-sm btn-warning px-3 text-dark fw-semibold">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger px-3" 
                                        onclick="if(confirm('Hapus jajanan ${menu.nama_menu}?')) { document.getElementById('delete-form-${menu.id}').submit(); }">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                                <form id="delete-form-${menu.id}" action="/menu/${menu.id}" method="POST" class="d-none">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </td>`;
                    } else if (userEmail !== 'guest') {
                        if (menu.stok > 0) {
                            actionColumnHtml = `
                                <td class="text-center">
                                    <form action="/keranjang/tambah/${menu.id}" method="POST" class="d-inline form-keranjang-aksi">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit" class="btn btn-sm btn-warning rounded-pill px-3 fw-bold text-dark shadow-sm">
                                            <i class="bi bi-cart-plus-fill"></i> Beli
                                        </button>
                                    </form>
                                </td>`;
                        } else {
                            actionColumnHtml = `
                                <td class="text-center">
                                    <button class="btn btn-sm btn-secondary rounded-pill px-3 small" disabled>Kosong</button>
                                </td>`;
                        }
                    } else {
                        actionColumnHtml = `<td class="text-center"><span class="text-white small" style="opacity: 0.6;">Silakan Login</span></td>`;
                    }

                    let rowHtml = `
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                            <td class="ps-4">
                                <span class="badge bg-transparent border text-white px-3 py-2 text-uppercase" style="border-color: rgba(74, 222, 128, 0.5) !important; background: rgba(74, 222, 128, 0.15) !important;">
                                    ${menu.kode_menu}
                                </span>
                            </td>
                            <td>${fotoHtml}</td>
                            <td>
                                <div class="fw-bold text-white">${menu.nama_menu}</div>
                                <small class="text-white" style="opacity: 0.6;">ID: #${menu.id}</small>
                            </td>
                            <td>${kategoriHtml}</td>
                            <td class="fw-bold" style="color: #67e8f9; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">Rp ${hargaFormatted}</td>
                            <td>${stokBadge}</td>
                            ${actionColumnHtml}
                        </tr>`;
                    
                    tableBody.insertAdjacentHTML('beforeend', rowHtml);
                });
            }
        } catch (error) {
            console.error("Gagal eksekusi live search:", error);
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', jalankanFilter);
    }
});
</script>
@endsection