@extends('layouts.app')

@section('content')
<div id="top"></div>

{{-- 🧼 FORCE LIGHT MODE TOTAL (Reset Semua Elemen ke Tema Terang) --}}
<style>
    /* Paksa Root HTML & Body kembali ke gaya Tema Terang murni */
    :root, html, body {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }

    /* 🟢 RE-DESIGN NAVBAR VERSI TERANG (Murni Hijau #556b2f dari Ujung ke Ujung) */
    nav, 
    .navbar, 
    header,
    .bg-dark, 
    .bg-body-tertiary {
        background-color: #556b2f !important;
        background: #556b2f !important;
    }

    /* Paksa container navbar agar warnanya menyatu sempurna */
    .navbar .container,
    .navbar .container-fluid {
        background-color: #556b2f !important;
        background: #556b2f !important;
    }

    /* Paksa teks di dalam navbar agar putih bersih & kontras */
    .navbar .navbar-brand,
    .navbar .navbar-nav .nav-link,
    .navbar .nav-item .nav-link,
    .navbar-nav .nav-link.active,
    .navbar a, 
    .navbar span {
        color: #ffffff !important;
        opacity: 1 !important;
        font-weight: 600 !important;
    }

    /* Hover link navbar menjadi kuning pastel */
    .navbar .navbar-nav .nav-link:hover,
    .navbar a:hover {
        color: #ffe69c !important;
    }

    /* Amankan tombol Register (Kuning tulisan gelap) */
    .navbar .btn-warning,
    .navbar .btn-warning * {
        color: #212529 !important;
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    /* ⚪ SEKARANG SEMUA CARD DIBUAT TRANSPARAN GLASSMORPHISM AGAR SERASI 🤍 */
    .card, .weather-card-glass {
        background: rgba(255, 255, 255, 0.4) !important; 
        backdrop-filter: blur(12px) saturate(120%) !important;
        -webkit-backdrop-filter: blur(12px) saturate(120%) !important;
        color: #212529 !important;
        border: 1px solid rgba(255, 255, 255, 0.5) !important;
    }

    /* Reset warna teks heading & paragraf agar selalu gelap (Tema Terang) */
    h1, h2, h3, h4, h5, h6, p, span:not(.badge), label {
        color: #212529 !important;
    }

    /* Batasan pemotong teks deskripsi produk */
    .text-line-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
    
    .object-fit-cover {
        object-fit: cover;
    }

    /* Efek hover gambar menu */
    .group-card img {
        transition: transform 0.3s ease;
    }
    .group-card:hover img {
        transform: scale(1.06);
    }

    /* Animasi cuaca matahari */
    .animate-bounce {
        display: inline-block;
        animation: bounce 2s infinite;
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
</style>

{{-- 📜 JAVASCRIPT UNTUK MENCOPET ATRIBUT DARK MODE YANG MENEMPEL DI LAYOUT UTAMA --}}
<script>
    (function () {
        // Copet paksa mode gelap jika diwariskan dari session/localStorage dashboard login
        document.documentElement.removeAttribute('data-bs-theme');
        document.body.removeAttribute('data-bs-theme');
        document.documentElement.setAttribute('data-bs-theme', 'light');
        document.body.setAttribute('data-bs-theme', 'light');
        
        document.documentElement.classList.remove('dark', 'theme-dark', 'bg-dark');
        document.body.classList.remove('dark', 'theme-dark', 'bg-dark');
    })();
</script>

<div class="container my-5">
    {{-- 🥞 HERO BANNER UTAMA VISYUM (TEMA TERANG) --}}
    <div class="row align-items-center py-5" style="min-height: 55vh;">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge text-white fw-bold px-3 py-2 rounded-pill mb-3" style="font-size: 0.9rem; background-color: #556b2f !important;">
                ✨ Jajanan Pasar Autentik & Higienis
            </span>
            <h1 class="display-4 fw-bold mb-3" style="letter-spacing: -1px; line-height: 1.2;">
                Eksplorasi Rasa <br><span style="color: #ffffff !important;">Jajanan Tradisional</span> <br>Kekinian Di Sini!
            </h1>
            <p class="lead mb-4" style="font-size: 1.1rem; color: #ffffff !important;">
                Menghadirkan kembali cita rasa legalisir aneka kue basah dan takjil pasar tradisional dengan standar kualitas modern yang bersih, lezat, dan ramah di kantong.
            </p>
            <div class="d-flex gap-3">
                <a href="{{ route('login') }}" class="btn btn-success btn-lg px-4 py-3 rounded-pill shadow-sm fw-bold" style="font-size: 1rem; background-color: #556b2f !important; border: none;">
                    Pesan Sekarang <i class="bi bi-box-arrow-in-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-6 text-center">
            <div class="position-relative d-inline-block">
                <div class="rounded-circle position-absolute top-50 start-50 translate-middle" style="width: 85%; height: 85%; opacity: 0.15; z-index: -1; background-color: #C5D89D;"></div>
                <img src="https://images.pexels.com/photos/37320808/pexels-photo-37320808.jpeg" 
                     alt="Foto Jajanan Pasar Vi's Yum" 
                     class="img-fluid rounded-4 shadow border border-white border-4" 
                     style="max-height: 380px; width: 100%; object-fit: cover;">
            </div>
        </div>
    </div>

    <hr class="my-5 border-secondary border-opacity-25">

    {{-- 🌤️ WIDGET PREDIKSI CUACA PINTAR (TRANSPARAN KUNING / GLASSMORPHISM) --}}
    <div class="mb-4 p-3 rounded-4 shadow-sm weather-card-glass" style="
         background: rgba(255, 223, 105, 0.25) !important; 
         backdrop-filter: blur(15px) saturate(130%) !important;
         -webkit-backdrop-filter: blur(15px) saturate(130%) !important;
         border: 1px solid rgba(255, 235, 150, 0.4) !important;">
        <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
            <div class="d-flex align-items-center gap-2 border-end border-warning border-opacity-50 pe-3 flex-shrink-0">
                <i class="bi bi-sun-fill text-warning fs-3 animate-bounce"></i>
                <div>
                    <span id="weather-temp-mini" class="fw-bold d-block lh-1" style="font-size: 1.25rem; color: #ffffff !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">--°C</span>
                    <small id="weather-desc-mini" class="d-block text-capitalize" style="font-size: 0.72rem; color: rgba(255, 255, 255, 0.75) !important;">Memuat cuaca...</small>
                </div>
            </div>
            <div>
                <p class="mb-0 small" style="line-height: 1.4; color: #ffffff !important; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                    <i class="bi bi-sparkles text-warning me-1"></i> 
                    Saat ini cuaca Jember cukup terik, cocok banget untuk menyantap jajanan manis dan segar dari <span class="fw-bold text-warning">visYum</span> biar harimu makin semangat! ☀️🍰
                </p>
            </div>
        </div>
    </div>

    {{-- 🏠 CARD PROFIL & ALAMAT VISYUM (TRANSPARAN GLASSMORPHISM) --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="row g-0">
            <div class="col-md-5 position-relative" style="min-height: 250px;">
                <img src="https://images.pexels.com/photos/20457220/pexels-photo-20457220.jpeg" 
                     alt="Profil Dapur visYum" 
                     class="w-100 h-100 object-fit-cover">
                <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);">
                    <span class="badge bg-warning text-dark fw-bold rounded-pill">Dapur Utama</span>
                </div>
            </div>
            <div class="col-md-7 p-4 d-flex flex-column justify-content-center">
                <h3 class="fw-bold mb-2" style="color: #ffc107 !important;"><i class="bi bi-shop-window me-2"></i>Vi'sYum</h3>
                
                <p class="small mb-4" style="line-height: 1.5; color: #ffffff !important;">
                    Toko kue rumahan yang mendedikasikan diri untuk melestarikan kelezatan jajanan tradisional Indonesia. Dari kue basah legendaris hingga aneka camilan pasar, VisYum hadir menyajikan produk buatan sendiri (homemade) dengan kualitas bahan terbaik demi mempertahankan cita rasa asli nusantara.
                </p>
                
                <div class="row g-3 border-top border-secondary border-opacity-25 pt-3">
                    <div class="col-sm-6">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="bi bi-geo-alt-fill text-danger fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small" style="color: #ffc107 !important;">Alamat Toko:</strong>
                                <span class="small text-muted">Jl. Kaliurang No. 12, Kecamatan Sumbersari, Jember, Jawa Timur</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-2 align-items-start">
                            <i class="bi bi-clock-history text-success fs-5 mt-1"></i>
                            <div>
                                <strong class="d-block small" style="color: #ffc107 !important;">Jam Operasional:</strong>
                                <span class="small text-muted">Setiap Hari<br>06:00 WIB - 16:00 WIB</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 📑 JUDUL ETALASE UTAMA --}}
    <div id="etalase-kue" class="pt-2 mb-4 text-center">
        <h2 class="fw-bold mb-1">Daftar Menu Kue</h2>
        <p class="text-muted">Dibuat fresh setiap hari langsung oleh Owner Vi's Yum</p>
        <hr class="mx-auto" style="width: 100px; border-width: 3px; border-radius: 2px; border-color: #556b2f !important; opacity: 0.7;">
    </div>

    {{-- 🔍 FILTER DAN PENCARIAN MENU (TRANSPARAN GLASSMORPHISM) --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold mb-2"><i class="bi bi-tags-fill me-1" style="color: #556b2f !important;"></i> Kategori Jajanan</label>
                <select id="filter-kategori" class="form-select rounded-pill border-secondary border-opacity-20" style="background-color: rgba(255,255,255,0.7) !important; color: #212529 !important;">
                    <option value="">Semua Kategori</option>
                    <option value="kue basah">Kue Basah</option>
                    <option value="kue kering">Kue Kering</option>
                    <option value="gorengan">Gorengan</option>
                </select>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-bold mb-2"><i class="bi bi-search me-1" style="color: #556b2f !important;"></i> Nama Jajanan Pasar</label>
                <div class="input-group">
                    <span class="input-group-text bg-white bg-opacity-50 text-muted border-end-0 rounded-start-pill"><i class="bi bi-search"></i></span>
                    <input type="text" id="search-menu" class="form-control bg-white bg-opacity-70 text-dark border-start-0 rounded-end-pill" placeholder="Cari kue kesukaanmu di sini... (misal: Klepon, Lumpur, Apem)">
                </div>
            </div>
        </div>
    </div>

    {{-- 🛒 CONTAINER PRODUK (TRANSPARAN GLASSMORPHISM) --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="menu-container">
        @forelse($menus as $item)
            <div class="col menu-item-card" data-category="{{ strtolower($item->category->nama_kategori ?? ($item->category->name ?? '')) }}" data-name="{{ strtolower($item->nama_menu ?? $item->name) }}">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative group-card">
                    
                    <span class="position-absolute top-0 end-0 text-white px-3 py-1 small fw-bold shadow-sm m-2 rounded-pill" style="z-index: 2; font-size: 0.75rem; background-color: #556b2f !important;">
                        {{ $item->category->nama_kategori ?? ($item->category->name ?? 'Kue') }}
                    </span>

                    <div style="height: 200px; overflow: hidden; background: #f1f1f1;" class="position-relative">
                        @if($item->foto)
                            <img src="{{ asset('uploads/menu/' . $item->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->nama_menu }}">
                        @elseif($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $item->name }}">
                        @else
                            <div class="w-100 h-100 d-flex flex-column align-items-center justify-content-center text-muted">
                                <i class="bi bi-image fs-1 mb-1"></i>
                                <span class="small">Belum Ada Foto</span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column p-3">
                        <h5 class="card-title fw-bold text-truncate mb-1">
                            {{ $item->nama_menu ?? $item->name }}
                        </h5>
                        <p class="card-text small text-muted text-line-clamp mb-3 flex-grow-1" style="font-size: 0.85rem;">
                            {{ $item->description ?? ($item->kode_menu ?? 'Deskripsi jajanan pasar tradisional buatan rumahan.') }}
                        </p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-light-subtle">
                            <div>
                                <span class="text-muted d-block small mb-0" style="font-size: 0.75rem;">Harga</span>
                                <span class="fw-bold fs-5" style="color: #ffffff !important;">Rp {{ number_format($item->harga ?? $item->price, 0, ',', '.') }}</span>
                            </div>
                            
                            @auth
                                <form action="{{ route('keranjang.tambah', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm text-white" style="width: 38px; height: 38px; background-color: #556b2f !important; border:none;" title="Tambah ke Keranjang">
                                        <i class="bi bi-plus-lg fs-5"></i>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 my-4 bg-transparent border-0" id="empty-state">
                <div class="d-inline-flex align-items-center justify-content-center bg-secondary bg-opacity-10 rounded-circle p-4 mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-shop text-muted fs-1"></i>
                </div>
                <h4 class="fw-bold mb-1">Belum Ada Kue di Etalase</h4>
                <p class="text-muted small">Hubungi Owner Vi's Yum untuk mengunggah varian kue pasar terbaru melalui dashboard.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- 📜 JAVASCRIPT FILTER & FETCH API CUACA JEMBER --}}
<script>
document.addEventListener("DOMContentLoaded", async function() {
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

    const tempMini = document.getElementById('weather-temp-mini');
    const descMini = document.getElementById('weather-desc-mini');

    try {
        await new Promise(resolve => setTimeout(resolve, 300));
        const response = await fetch('https://wttr.in/Jember?format=j1');
        if (!response.ok) throw new Error('Koneksi API bermasalah');
        
        const data = await response.json();
        const currentCondition = data.current_condition[0];

        if (tempMini) tempMini.innerText = currentCondition.temp_C + '°C';
        if (descMini) descMini.innerText = currentCondition.weatherDesc[0].value;
    } catch (error) {
        console.error('Gagal memuat cuaca via API:', error);
        if (tempMini) tempMini.innerText = '31°C'; 
        if (descMini) descMini.innerText = 'Cerah Berawan';
    }
});
</script>

<link class="jsbin" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
@endsection