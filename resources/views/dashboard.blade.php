@extends('layouts.app')

@section('content')
<div id="top"></div>

<div class="container my-5">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 10px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 🥞 HERO BANNER UTAMA VISYUM --}}
    <div class="row align-items-center py-5" style="min-height: 60vh;">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge bg-success text-white fw-bold px-3 py-2 rounded-pill mb-3" style="font-size: 0.9rem; background: rgba(25, 135, 84, 0.4) !important; border: 1px solid rgba(255,255,255,0.2);">
                ✨ Jajanan Pasar Autentik & Higienis
            </span>
            <h1 class="display-4 fw-black text-white mb-3" style="letter-spacing: -1px; line-height: 1.2; text-shadow: 0 2px 4px rgba(0,0,0,0.5); font-weight: 900;">
                Eksplorasi Rasa <br><span class="text-warning">Jajanan Tradisional</span> <br>Kekinian Di Sini!
            </h1>
            {{-- 🌟 FIX: Mengubah class menjadi text-white murni & membetulkan typo legendaris 🌟 --}}
            <p class="lead text-white mb-4" style="font-size: 1.1rem; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">
                Menghadirkan kembali cita rasa legendaris aneka kue basah dan takjil pasar tradisional dengan standar kualitas modern yang bersih, lezat, dan ramah di kantong.
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('keranjang.index') }}" class="btn btn-success btn-lg px-4 py-3 rounded-pill shadow fw-bold" style="font-size: 1rem; background: #2e7d32 !important; border: none;">
                    Pesan Sekarang <i class="bi bi-bag-heart-fill ms-1"></i>
                </a>
                
                @if(Auth::check() && Auth::user()->email == 'via@owner.com')
                    <a href="{{ route('menu.index') }}" class="btn btn-warning btn-lg px-4 py-3 rounded-pill shadow fw-bold text-dark" style="font-size: 1rem;">
                        Kelola Menu <i class="bi bi-egg-fried ms-1"></i>
                    </a>
                @else
                    <a href="{{ route('pesanan.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill shadow fw-bold" style="font-size: 1rem;">
                        Status Pesanan <i class="bi bi-clock-history ms-1"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <div class="position-relative d-inline-block">
                <div class="bg-success rounded-circle position-absolute top-50 start-50 translate-middle" style="width: 85%; height: 85%; opacity: 0.1; z-index: -1;"></div>
                <img src="https://images.pexels.com/photos/37320808/pexels-photo-37320808.jpeg" 
                     alt="Foto Jajanan Pasar Vi's Yum" 
                     class="img-fluid rounded-4 shadow-lg border border-white border-4" 
                     style="max-height: 380px; width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>

    <hr class="my-5 border-white border-opacity-25">

    {{-- 🌤️ WIDGET PREDIKSI CUACA PINTAR (KUNING TRANSPARAN MINI) --}}
    <div class="mb-4 p-3 rounded-4 shadow-sm" style="background: rgba(255, 193, 7, 0.12); backdrop-filter: blur(8px); border: 1px solid rgba(255, 193, 7, 0.25); color: white;">
        <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
            {{-- Sisi Kiri: Info Suhu dari API --}}
            <div class="d-flex align-items-center gap-2 border-end border-white border-opacity-25 pr-3 pe-3 flex-shrink-0">
                <i class="bi bi-sun-fill text-warning fs-3 animate-bounce"></i>
                <div>
                    <span id="weather-temp-mini" class="fw-bold d-block lh-1" style="font-size: 1.25rem;">--°C</span>
                    <small id="weather-desc-mini" class="text-white-50 d-block text-capitalize" style="font-size: 0.72rem;">Memuat cuaca...</small>
                </div>
            </div>
            
            {{-- Sisi Kanan: Deskripsi Dinamis Penarik Minat Pembeli --}}
            <div>
                <p class="mb-0 small" style="line-height: 1.4;">
                    <i class="bi bi-sparkles text-warning me-1"></i> 
                    Saat ini cuaca Jember cukup terik, cocok banget untuk menyantap jajanan manis dan segar dari <span class="text-warning fw-bold">visYum</span> biar harimu makin semangat! ☀️🍰
                </p>
            </div>
        </div>
    </div>

    {{-- 🏠 PART BARU: CARD PROFIL & ALAMAT VISYUM (PERSIS DI BAWAH CUACA) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5" style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15) !important;">
        <div class="row g-0">
            {{-- Sisi Kiri: Foto Estetik Pexels Pilihanmu --}}
            <div class="col-md-5 position-relative" style="min-height: 250px;">
                <img src="https://images.pexels.com/photos/20457220/pexels-photo-20457220.jpeg" 
                     alt="Profil Dapur visYum" 
                     class="w-100 h-100 object-fit-cover">
                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                    <span class="badge bg-warning text-dark fw-bold rounded-pill">Dapur Utama</span>
                </div>
            </div>
            {{-- Sisi Kanan: Teks Profil, Alamat & Jam Operasional --}}
            <div class="col-md-7 p-4 d-flex flex-column justify-content-center text-white">
                <h3 class="fw-bold mb-2 text-warning"><i class="bi bi-shop-window me-2"></i>VisYum</h3>
                <p class="small text-white-50 mb-4" style="line-height: 1.5; color: #FFFFFF !important;">
                    Toko kue rumahan yang mendedikasikan diri untuk melestarikan kelezatan jajanan tradisional Indonesia. Dari kue basah legendaris hingga aneka camilan pasar, VisYum hadir menyajikan produk buatan sendiri (homemade) dengan kualitas bahan terbaik demi mempertahankan cita rasa asli nusantara.
                </p>
                <div class="row g-3 border-top border-white border-opacity-10 pt-3">
                    <div class="col-sm-6">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="bi bi-geo-alt-fill text-danger fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small text-warning">Alamat Toko:</strong>
                                <span class="small text-white-50">Jl. Kaliurang No. 12, Kecamatan Sumbersari, Jember, Jawa Timur</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="bi bi-clock-history text-success fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small text-warning">Jam Operasional:</strong>
                                <span class="small text-white-50">Setiap Hari<br>06:00 WIB - 16:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📑 JUDUL ETALASE UTAMA --}}
    <div id="etalase-kue" class="pt-2 mb-4 text-center">
        <h2 class="fw-bold text-white mb-1" style="text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Daftar Menu Kue</h2>
        <p class="text-white-50">Dibuat fresh setiap hari langsung oleh Owner Vi's Yum</p>
        <hr class="mx-auto border-light opacity-25" style="width: 100px; border-width: 3px; border-radius: 2px;">
    </div>

    {{-- 🔍 FILTER DAN PENCARIAN MENU --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5" style="background: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15) !important;">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold text-white mb-2"><i class="bi bi-tags-fill me-1"></i> Kategori Jajanan</label>
                <select id="filter-kategori" class="form-select rounded-pill">
                    <option value="">Semua Kategori</option>
                    <option value="kue basah">Kue Basah</option>
                    <option value="kue kering">Kue Kering</option>
                    <option value="gorengan">Gorengan</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-bold text-white mb-2"><i class="bi bi-search me-1"></i> Nama Jajanan Pasar</label>
                <div class="input-group">
                    <span class="input-group-text bg-white bg-opacity-20 text-white border-end-0 rounded-start-pill" style="border: 1px solid rgba(255,255,255,0.2);"><i class="bi bi-search"></i></span>
                    <input type="text" id="search-menu" class="form-control bg-white bg-opacity-20 text-white border-start-0 rounded-end-pill placeholder-white-50" placeholder="Cari kue kesukaanmu di sini... (misal: Klepon, Lumpur, Apem)" style="border: 1px solid rgba(255,255,255,0.2);">
                </div>
            </div>
        </div>
    </div>

    {{-- 🛒 CONTAINER PRODUK --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="menu-container">
        @php
            $menus = \App\Models\Menu::all();
        @endphp

        @forelse($menus as $item)
            <div class="col menu-item-card" data-category="{{ strtolower($item->category->nama_kategori ?? ($item->category->name ?? '')) }}" data-name="{{ strtolower($item->nama_menu ?? $item->name) }}">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative group-card" style="background: rgba(255, 255, 255, 0.18) !important; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2) !important;">
                    
                    <span class="position-absolute top-0 end-0 bg-success text-white px-3 py-1 small fw-bold shadow-sm m-2 rounded-pill" style="z-index: 2; font-size: 0.75rem;">
                        {{ $item->category->nama_kategori ?? ($item->category->name ?? 'Kue') }}
                    </span>

                    <div style="height: 200px; overflow: hidden; background: rgba(0,0,0,0.1);" class="position-relative">
                        @if($item->foto)
                            <img src="{{ asset('uploads/menu/' . $item->foto) }}" class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $item->nama_menu }}">
                        @elseif($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-100 h-100 object-fit-cover transition-transform" alt="{{ $item->name }}">
                        @else
                            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-white-50">
                                <i class="bi bi-image fs-1 mb-1"></i>
                                <span class="small">Belum Ada Foto</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title fw-bold text-white text-truncate mb-1" style="text-shadow: 0 1px 2px rgba(0,0,0,0.5);">
                            {{ $item->nama_menu ?? $item->name }}
                        </h5>
                        <p class="card-text small text-white-50 text-line-clamp mb-3 flex-grow-1" style="font-size: 0.85rem;">
                            {{ $item->description ?? ($item->kode_menu ?? 'Deskripsi jajanan pasar tradisional buatan rumahan.') }}
                        </p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-light border-opacity-10">
                            <div>
                                <span class="text-white-50 d-block small mb-0" style="font-size: 0.75rem;">Harga</span>
                                <span class="fw-bold text-warning fs-5">Rp {{ number_format($item->harga ?? $item->price, 0, ',', '.') }}</span>
                            </div>
                            
                            <a href="{{ route('keranjang.index') }}" class="btn btn-success btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm button-plus" style="width: 38px; height: 38px; background: #2e7d32 !important; border:none;" title="Pesan Kue">
                                <i class="bi bi-cart-plus fs-5 text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 my-4 bg-transparent border-0" id="empty-state">
                <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-10 rounded-circle p-4 mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-shop text-white-50 fs-1"></i>
                </div>
                <h4 class="fw-bold text-white mb-1">Belum Ada Kue di Etalase</h4>
                <p class="text-white-50 small">Varian kue pasar dari database Owner belum termuat.</p>
            </div>
        @endforelse
    </div>

    <div class="my-4"></div>

    {{-- 📈 STATISTIK KUNJUNGAN OWNER --}}
    @if(Auth::check() && Auth::user()->email == 'via@owner.com')
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; background: rgba(25, 135, 84, 0.2) !important; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2) !important;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;">
                            <i class="bi bi-eye-fill fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-white mb-0" style="font-size: 1.1rem;">Statistik Kunjungan Halaman Jajanan</h5>
                            <small class="text-white-50">Memantau lalu lintas halaman /menu melalui Stateful Session</small>
                        </div>
                    </div>
                </div>

                <hr class="my-3 border-white border-opacity-25">

                <div class="row g-3 text-center">
                    <div class="col-md-4">
                        <div class="p-3 rounded border border-white border-opacity-25" style="background: rgba(255, 255, 255, 0.1);">
                            <span class="text-white-50 small d-block mb-1">Jumlah Kunjungan</span>
                            <span class="fs-4 fw-bold text-white">{{ session('jumlah_kunjungan', 0) }} Kali</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded border border-white border-opacity-25" style="background: rgba(255, 255, 255, 0.1);">
                            <span class="text-white-50 small d-block mb-1">Kunjungan Pertama</span>
                            <span class="fw-semibold text-white" style="font-size: 0.95rem;">
                                {{ session('kunjungan_pertama', '-') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded border border-white border-opacity-25" style="background: rgba(255, 255, 255, 0.1);">
                            <span class="text-white-50 small d-block mb-1">Kunjungan Terakhir</span>
                            <span class="fw-semibold text-white" style="font-size: 0.95rem;">
                                {{ session('kunjungan_terakhir', '-') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- 📜 MANAGEMENT JAVASCRIPT --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.body.classList.add('dashboard-theme');
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('search-menu');
    const kategoriSelect = document.getElementById('filter-kategori');
    const menuCards = document.querySelectorAll('.menu-item-card');

    function filterMenu() {
        const searchText = searchInput.value.toLowerCase().trim();
        const selectedKategori = kategoriSelect.value.toLowerCase();

        menuCards.forEach(card => {
            const namaKue = card.getAttribute('data-name') || '';
            const kategoriKue = card.getAttribute('data-category') || '';

            const cocokSearch = namaKue.includes(searchText);
            const cocokKategori = selectedKategori === "" || kategoriKue === selectedKategori;

            if (cocokSearch && cocokKategori) {
                card.style.setProperty('display', 'block', 'important');
            } else {
                card.style.setProperty('display', 'none', 'important');
            }
        });
    }

    if(searchInput) searchInput.addEventListener('input', filterMenu);
    if(kategoriSelect) kategoriSelect.addEventListener('change', filterMenu);
});
</script>

{{-- 🌤️ LOGIKA FETCH CUACA BARU --}}
<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const tempMini = document.getElementById('weather-temp-mini');
        const descMini = document.getElementById('weather-desc-mini');

        try {
            await new Promise(resolve => setTimeout(resolve, 500));
            const response = await fetch('https://wttr.in/Jember?format=j1');
            if (!response.ok) throw new Error('Koneksi API bermasalah');
            
            const data = await response.json();
            const currentCondition = data.current_condition[0];

            if (tempMini) {
                tempMini.innerText = currentCondition.temp_C + '°C';
            }
            if (descMini) {
                descMini.innerText = currentCondition.weatherDesc[0].value;
            }
        } catch (error) {
            console.error('Gagal memuat cuaca via API:', error);
            if (tempMini) {
                tempMini.innerText = '31°C'; 
            }
            if (descMini) {
                descMini.innerText = 'Cerah Berawan';
            }
        }
    });
</script>

<style>
    /* 🌟 FIX: Hover Navbar jadi kuning di Mode Gelap (.dashboard-theme) 🌟 */
    .dashboard-theme .navbar .navbar-nav .nav-link:hover,
    .dashboard-theme .navbar a:hover,
    .dashboard-theme .navbar button:hover,
    .dashboard-theme .navbar-dark .navbar-nav .nav-link:hover {
        color: #ffc107 !important;
        transition: color 0.2s ease-in-out !important;
    }

    .text-line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .group-card img {
        transition: transform 0.3s ease;
    }
    .group-card:hover img {
        transform: scale(1.06);
    }
    .placeholder-white-50::placeholder {
        color: rgba(255, 255, 255, 0.6) !important;
    }
    .button-plus:hover {
        background-color: #1b5e20 !important;
        transform: scale(1.08);
        transition: all 0.2s ease;
    }
    .animate-bounce {
        display: inline-block;
        animation: bounce 2s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
</style>

<link class="jsbin" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
@endsection