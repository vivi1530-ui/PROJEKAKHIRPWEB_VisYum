<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vi's Yum - Jajanan Kue Pasar Tradisional</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            let nameEQ = name + "=";
            let ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }

        window.applyPreferences = function(theme, fontSize) {
            const htmlEl = document.documentElement;
            if (theme === 'dark') {
                htmlEl.classList.add('dark-mode');
            } else if (theme === 'system') {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    htmlEl.classList.add('dark-mode');
                } else {
                    htmlEl.classList.remove('dark-mode');
                }
            } else {
                htmlEl.classList.remove('dark-mode');
            }

            htmlEl.classList.remove('font-small', 'font-medium', 'font-large');
            if (fontSize) {
                htmlEl.classList.add('font-' + fontSize);
            } else {
                htmlEl.classList.add('font-medium');
            }
        }

        const globalInitTheme = getCookie('theme') || 'light';
        const globalInitFont = getCookie('font_size') || 'medium';
        window.applyPreferences(globalInitTheme, globalInitFont);
    </script>

    <style>
        html { scroll-behavior: smooth; }
        
        /* 🟢 NAVBAR UTAMA TEMA TERANG (HIJAU VISYUM) */
        .custom-navbar {
            background-color: #556b2f !important; 
            margin-bottom: 0px; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: background-color 0.3s ease;
        }

        /* Teks navbar utama wajib PUTIH BERSIH agar kontras */
        .custom-navbar .navbar-brand,
        .custom-navbar .nav-link,
        .custom-navbar .navbar-text,
        .custom-navbar .dropdown-toggle {
            color: #ffffff !important;
            font-weight: 600 !important;
            text-shadow: none !important;
        }

        .custom-navbar .navbar-text {
            opacity: 0.8;
            color: #ffffff !important;
            font-weight: 500 !important;
        }

        .custom-navbar .nav-link.active {
            border-bottom: 2px solid #ffffff !important;
        }

        .custom-navbar .nav-link:hover,
        .custom-navbar .dropdown-toggle:hover {
            color: #ffe69c !important;
        }
        
        html.font-small body { font-size: 14px !important; }
        html.font-medium body { font-size: 16px !important; }
        html.font-large body { font-size: 20px !important; }

        /* ================= 🌍 BACKGROUND GLOBAL ================= */
        body {
            position: relative;
            min-height: 100vh;
            background-color: #f8f9fa;
            z-index: 0;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Gambar latar belakang blur selalu aktif */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: linear-gradient(rgba(10, 25, 15, 0.45), rgba(10, 25, 15, 0.50)), 
                              url('https://images.pexels.com/photos/37866312/pexels-photo-37866312.jpeg');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            background-size: cover;
            filter: blur(4px);
            -webkit-filter: blur(4px);
            transform: scale(1.02);
            z-index: -1;
            transition: background-image 0.3s ease-in-out;
        }

        /* ================= ☀️ DESAIN TRANSPARAN & TEKS PUTIH (SAMA RATALKAN GLOBAL) ================= */
        body .card, 
        body .bg-white,
        body .list-group-item {
            background: rgba(255, 255, 255, 0.25) !important;
            backdrop-filter: blur(15px) saturate(120%) !important;
            -webkit-backdrop-filter: blur(15px) saturate(120%) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        /* 🤍 SEMUA TULISAN DI PAKSA JADI PUTIH BERSIH SESUAI KEINGINANMU 🤍 */
        body h1, body h2, body h3, body h4, body h5, body h6, 
        body p, body span:not(.badge), body label, 
        body .text-dark, body .text-muted, body .card-title, body .card-text {
            color: #ffffff !important;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;
        }

        /* Form input, search bar menu agar transparan & teksnya putih */
        body .form-control, body .form-select {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
        body .form-control::placeholder {
            color: rgba(255, 255, 255, 0.75) !important;
        }

        /* Dropdown pilihan di dalam form agar teks pilihan tetap hitam saat diklik */
        select option, .form-select option, body select option, body .form-select option {
            background-color: #ffffff !important;
            color: #212529 !important;
            text-shadow: none !important;
        }

        /* Desain Tabel Transparan Teks Putih */
        body .table {
            color: #ffffff !important;
            background: transparent !important;
            --bs-table-bg: transparent !important;
        }
        body .table tr {
            background: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        body .table th {
            background: rgba(255, 255, 255, 0.25) !important;
            color: #ffffff !important;
            border: none !important;
        }
        body .table td {
            background: transparent !important;
            color: #f8f9fa !important;
        }

        /* ================= 🌙 SUPREME DARK MODE OVERRIDE ================ */
        html.dark-mode body::before {
            background-image: linear-gradient(rgba(5, 22, 16, 0.84), rgba(3, 14, 10, 0.90)), 
                              url('https://images.pexels.com/photos/37866312/pexels-photo-37866312.jpeg');
        }

        html.dark-mode .custom-navbar {
            background-color: #032519 !important;
            border-bottom: 1px solid rgba(25, 135, 84, 0.2);
        }

        html.dark-mode .custom-navbar .navbar-brand,
        html.dark-mode .custom-navbar .nav-link,
        html.dark-mode .custom-navbar .navbar-text {
            color: #f8fafc !important;
            font-weight: 600 !important;
        }

        html.dark-mode .custom-navbar .nav-link.active {
            border-bottom-color: #f8fafc !important;
        }

        html.dark-mode, html.dark-mode body {
            background-color: #0c1220 !important; 
            color: #f1f5f9 !important;
        }

        html.dark-mode body .card, 
        html.dark-mode body .bg-white, 
        html.dark-mode body .list-group-item {
            background: rgba(6, 44, 30, 0.65) !important;
            border: 1px solid rgba(25, 135, 84, 0.4) !important;
            color: #f8fafc !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
        }

        html.dark-mode body .text-dark, html.dark-mode body h1, html.dark-mode body h2, 
        html.dark-mode body h3, html.dark-mode body h4, html.dark-mode body h5, 
        html.dark-mode body label, html.dark-mode body span, html.dark-mode body p {
            color: #f8fafc !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.6) !important;
        }
        
        html.dark-mode body .text-muted { color: #94a3b8 !important; text-shadow: none !important;}
        
        html.dark-mode body .form-control, 
        html.dark-mode body .form-select {
            background-color: rgba(12, 19, 34, 0.6) !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        /* ================= 👥 DROPDOWN MENU UTILITY ================= */
        .dropdown-menu {
            background-color: #ffffff !important;
            border: 1px solid rgba(0,0,0,0.15) !important;
        }
        .dropdown-menu .dropdown-item {
            color: #212529 !important;
            text-shadow: none !important;
        }
        .dropdown-menu .dropdown-item i, 
        .dropdown-menu .dropdown-item span,
        .dropdown-menu .dropdown-item form,
        .dropdown-menu .dropdown-item button {
            color: inherit !important;
            text-shadow: none !important;
        }
        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa !important;
            color: #1e2125 !important;
        }

        html.dark-mode .dropdown-menu {
            background-color: #1e293b !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
        }
        html.dark-mode .dropdown-menu .dropdown-item {
            color: #f1f5f9 !important;
            text-shadow: none !important;
        }

        /* 🆕 STYLING KHUSUS HOVER SOSMED FOOTER BARU */
        .sosmed-hover {
            transition: transform 0.3s ease, filter 0.3s ease;
        }
        .sosmed-hover:hover {
            transform: translateY(-5px);
            filter: drop-shadow(0 4px 10px rgba(255, 255, 255, 0.25));
        }
        .sosmed-hover:hover span {
            color: #ffc107 !important;
        }
    </style>
</head>
<body class="{{ !auth()->check() ? 'is-public-page' : '' }}">

    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar py-3 fixed-top shadow-sm">
        <div class="container">
            <div class="d-flex align-items-center">
                <span class="navbar-brand fw-bold mb-0 h1 me-2">Vi's Yum</span>
                <span class="navbar-text border-start border-white border-opacity-25 ps-2 d-none d-sm-inline">
                    Jajanan Kue Pasar Tradisional
                </span>
            </div>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    @auth
                        @if(auth()->user()->email === 'via@owner.com')
                            <li class="nav-item">
                                <a id="nav-beranda" class="nav-link {{ Request::is('owner/dashboard') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a id="nav-menu" class="nav-link {{ Request::is('menu*') ? 'active' : '' }}" href="{{ route('menu.index') }}">Menu</a>
                            </li>
                            <li class="nav-item">
                                <a id="nav-pesanan" class="nav-link {{ Request::is('owner/pesanan') ? 'active' : '' }}" href="{{ route('owner.pesanan') }}">Pesanan</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('home') ? 'active' : '' }}" href="{{ url('/home') }}">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center {{ Request::is('beli*') ? 'active' : '' }}" href="{{ route('beli.index') }}">
                                    Beli
                                    @if(session('keranjang') && count(session('keranjang')) > 0)
                                        <span class="badge bg-danger ms-1 px-2 rounded-pill" style="font-size: 0.7rem; color: #ffffff !important;">
                                            {{ count(session('keranjang')) }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('pesanan*') ? 'active' : '' }}" href="{{ route('pesanan.index') }}">Pesanan Saya</a>
                            </li>
                        @endif

                        <li class="nav-item me-1">
                            <button id="theme-toggle" class="btn btn-sm btn-light border-0 shadow-sm rounded-pill px-3 d-flex align-items-center gap-1">
                                <i id="theme-toggle-icon" class="bi bi-moon-stars-fill text-primary"></i> 
                                <span id="theme-toggle-text" class="fw-bold" style="font-size: 0.85rem; color: #212529 !important;">Dark Mode</span>
                            </button>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-2" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li>
                                    <a class="dropdown-item" href="{{ route('settings.index') }}">
                                        <i class="bi bi-gear-fill me-1"></i> <span>Pengaturan Tema</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger d-flex align-items-center w-100 border-0 bg-transparent">
                                            <i class="bi bi-box-arrow-right me-1"></i> <span>Log Out</span>
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="#etalase-kue">Menu</a></li>
                        <li class="nav-item ms-lg-2"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item ms-lg-2"><a class="btn btn-warning text-dark fw-bold btn-sm rounded-pill px-3" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main style="padding-top: 85px;">
        @yield('content')
    </main>

    <footer class="text-center py-5 mt-5 border-top border-secondary border-opacity-20" style="background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
        <div class="container">
            <h5 class="fw-bold mb-2" style="color: #ffc107; font-size: 1.3rem; text-shadow: 0 1px 3px rgba(0,0,0,0.5) !important;">Yuk, Kepoin Vi's Yum di Sosmed!</h5>
            <p class="small mb-4" style="color: rgba(255, 255, 255, 0.8) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.4) !important;">Ikuti keseruan kami dan dapatkan info promo menarik setiap hari</p>
            
            <div class="d-flex justify-content-center gap-4 align-items-center flex-wrap mb-4">
                <a href="https://instagram.com/visyum.id" target="_blank" class="text-decoration-none sosmed-hover mx-3">
                    <i class="bi bi-instagram d-block mb-1 text-danger" style="font-size: 2rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>
                    <span class="small fw-semibold d-block text-white">@visyum.id</span>
                </a>

                <a href="https://tiktok.com/@visyum.id" target="_blank" class="text-decoration-none sosmed-hover mx-3">
                    <i class="bi bi-tiktok d-block mb-1 text-light" style="font-size: 2rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>
                    <span class="small fw-semibold d-block text-white">Vi's Yum TikTok</span>
                </a>

                <a href="https://wa.me/6281234567890" target="_blank" class="text-decoration-none sosmed-hover mx-3">
                    <i class="bi bi-whatsapp d-block mb-1 text-success" style="font-size: 2rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>
                    <span class="small fw-semibold d-block text-white">Hubungi Admin</span>
                </a>
            </div>

            <hr class="my-4 border-light opacity-25" style="max-width: 300px; margin: 0 auto;">
            
            <p class="mb-0 small" style="color: rgba(255, 255, 255, 0.6) !important; text-shadow: 0 1px 2px rgba(0,0,0,0.4) !important;">&copy; 2026 Vi's Yum - Jajanan Kesukaan Kita Semua</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.body.classList.contains('is-public-page')) {
            document.documentElement.classList.remove('dark-mode');
            return;
        }

        const toggleBtn = document.getElementById('theme-toggle');
        const toggleIcon = document.getElementById('theme-toggle-icon');
        const toggleText = document.getElementById('theme-toggle-text');

        function updateButtonUI(themeName) {
            if (!toggleBtn) return;
            if (themeName === 'dark') {
                toggleIcon.className = 'bi bi-sun-fill text-warning';
                toggleText.innerText = 'Light Mode';
                toggleText.style.setProperty('color', '#ffffff', 'important');
                toggleBtn.className = 'btn btn-sm btn-dark border border-secondary shadow-sm rounded-pill px-3 text-white d-flex align-items-center gap-1';
            } else {
                toggleIcon.className = 'bi bi-moon-stars-fill text-primary';
                toggleText.innerText = 'Dark Mode';
                toggleText.style.setProperty('color', '#212529', 'important');
                toggleBtn.className = 'btn btn-sm btn-light border-0 shadow-sm rounded-pill px-3 d-flex align-items-center gap-1';
            }
        }

        const currentActiveTheme = getCookie('theme') || 'light';
        updateButtonUI(currentActiveTheme);

        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const isDarkActive = document.documentElement.classList.contains('dark-mode');
                const currentFont = getCookie('font_size') || 'medium';

                if (isDarkActive) {
                    setCookie('theme', 'light', 7); 
                    window.applyPreferences('light', currentFont);
                    updateButtonUI('light');
                } else {
                    setCookie('theme', 'dark', 7);
                    window.applyPreferences('dark', currentFont);
                    updateButtonUI('dark');
                }
            });
        }
    });
    </script>
</body>
</html>