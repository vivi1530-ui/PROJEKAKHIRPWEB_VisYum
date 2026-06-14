@extends('layouts.app')



@section('content')

<div class="container py-4">

    <div class="row">

        {{-- SISI KIRI: ETALASE KUE PASAR --}}

        <div class="col-lg-8 mb-4">

            <div class="mb-4">

                <h2 class="fw-bold text-white mb-1">🍱 Etalase Menu Kue Pasar</h2>

                <p class="text-white-50 small">Dibuat fresh setiap hari dengan bahan-bahan pilihan terbaik untukmu.</p>

            </div>



            {{-- Grid Item Menu Jajanan --}}

            <div class="row g-3">

                @forelse($menus as $menu)

                <div class="col-md-6">

                    {{-- 🟢 EFISIENSI STOK: Jika stok < 1, card otomatis pudar, abu-abu, dan mengunci interaksi klik --}}

                    <div class="card h-100 border-0 shadow-sm position-relative group-card"

                         style="border-radius: 15px; overflow: hidden; background: rgba(255, 255, 255, 0.15) !important; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15) !important; {{ ($menu->stok ?? 0) < 1 ? 'opacity: 0.35; filter: grayscale(100%); pointer-events: none;' : '' }}">

                       

                        {{-- 🏷️ Label Kategori --}}

                        <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2" style="z-index: 2; border-radius: 20px; background: #2e7d32 !important;">

                            {{ $menu->category->nama_kategori ?? ($menu->category->name ?? ($menu->kategori ?? 'Kue')) }}

                        </span>

                       

                        {{-- 📸 Wadah Gambar --}}

                        <div style="height: 190px; overflow: hidden; background: rgba(0,0,0,0.2);" class="w-100 position-relative">

                            @if($menu->foto && file_exists(public_path('uploads/menu/' . $menu->foto)))

                                <img src="{{ asset('uploads/menu/' . $menu->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $menu->nama_menu }}" style="filter: brightness(0.95);">

                            @elseif($menu->foto)

                                <img src="{{ asset('storage/' . $menu->foto) }}" class="w-100 h-100 object-fit-cover" alt="{{ $menu->nama_menu }}" style="filter: brightness(0.95);">

                            @elseif($menu->image)

                                <img src="{{ asset('storage/' . $menu->image) }}" class="w-100 h-100 object-fit-cover" alt="{{ $menu->nama_menu }}" style="filter: brightness(0.95);">

                            @else

                                <img src="https://images.pexels.com/photos/37866312/pexels-photo-37866312.jpeg" class="w-100 h-100 object-fit-cover" alt="Default Jajanan" style="filter: brightness(0.95);">

                            @endif

                        </div>

                       

                        <div class="card-body d-flex flex-column justify-content-between p-3 text-white">

                            <div>

                                <h5 class="fw-bold text-white mb-1" style="text-shadow: 0 1px 2px rgba(0,0,0,0.4);">{{ $menu->nama_menu ?? $menu->name }}</h5>

                                {{-- Menampilkan info sisa stok jajanan --}}

                                <small class="text-warning d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">

                                    <i class="bi bi-box-seam me-1"></i> Sisa Stok: {{ $menu->stok ?? 0 }} porsi

                                </small>

                            </div>

                           

                            <div class="d-flex justify-content-between align-items-center mt-2 border-top border-light border-opacity-10 pt-3">

                                <div>

                                    <small class="text-white-50 d-block" style="font-size: 0.75rem;">Harga</small>

                                    <span class="fw-bold text-warning fs-5">Rp {{ number_format($menu->harga ?? $menu->price, 0, ',', '.') }}</span>

                                </div>

                               

                                {{-- 🟢 VALIDASI TOMBOL DI SISI PEMBELI --}}

                                @if(($menu->stok ?? 0) < 1)

                                    {{-- Jika stok kosong, tampilkan label Habis --}}

                                    <span class="badge bg-danger px-3 py-2 fw-bold" style="border-radius: 8px; font-size: 0.85rem;">

                                        <i class="bi bi-x-circle me-1"></i> Habis

                                    </span>

                                @else

                                    {{-- Jika stok tersedia, form pembelian aktif --}}

                                    <form action="{{ route('keranjang.tambah', $menu->id) }}" method="POST" class="m-0">

                                        @csrf

                                        <div class="d-flex gap-1 align-items-center">

                                            <input type="number" name="jumlah" value="1" min="1" max="{{ $menu->stok }}" class="form-control form-control-sm text-center p-1 text-white border-0" style="width: 50px; border-radius: 8px; background: rgba(255,255,255,0.2);" required>

                                            <button type="submit" class="btn btn-success btn-sm p-2 rounded-circle d-flex align-items-center justify-content-center button-plus" style="width: 36px; height: 36px; background: #2e7d32 !important; border: none;">

                                                <i class="bi bi-plus-lg fs-5 text-white"></i>

                                            </button>

                                        </div>

                                    </form>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                @empty

                <div class="col-12 text-center py-5">

                    <p class="text-white-50">Ups, belum ada jajanan pasar yang tersedia hari ini.</p>

                </div>

                @endforelse

            </div>

        </div>



        {{-- SISI KANAN: RINGKASAN KANTONG BELANJA & CHECKOUT --}}

        <div class="col-lg-4">

            <div class="card border-0 text-white sticky-top shadow animate-checkout-card"

                 style="top: 100px; border-radius: 15px; background: rgba(15, 23, 42, 0.45) !important; backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.15) !important;">

               

                <div class="card-header bg-transparent border-bottom border-light border-opacity-10 py-3">

                    <h5 class="fw-bold mb-0 text-warning"><i class="bi bi-cart3 me-2"></i>Kantong Belanja</h5>

                </div>

               

                <div class="card-body">

                    {{-- 🟢 PENANGKAP ALERT PESAN ERROR VALIDASI STOK --}}

                    @if(session('error'))

                        <div class="alert alert-danger p-2 small border-0 mb-3 text-white rounded-3 d-flex align-items-center gap-2" style="background: rgba(220, 53, 69, 0.45);">

                            <i class="bi bi-exclamation-triangle-fill text-danger fs-6"></i>

                            <div>{{ session('error') }}</div>

                        </div>

                    @endif



                    @if(session('success'))

                        <div class="alert alert-success p-2 small border-0 mb-3 text-white rounded-3 d-flex align-items-center gap-2" style="background: rgba(25, 135, 84, 0.45);">

                            <i class="bi bi-check-circle-fill text-success fs-6"></i>

                            <div>{{ session('success') }}</div>

                        </div>

                    @endif



                    {{-- Alert Error jika Validasi bawaan Laravel Gagal --}}

                    @if ($errors->any())

                        <div class="alert alert-danger p-2 small border-0 mb-3 text-white rounded-3" style="background: rgba(220, 53, 69, 0.3);">

                            <ul class="m-0 p-0 ps-3">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif



                    @if(!isset($pesananAktif) || $pesananAktif->details->count() == 0)

                        <div class="text-center py-5 opacity-50">

                            <i class="bi bi-bag-x display-4 mb-2 d-block"></i>

                            <p class="small">Keranjang belanjamu kosong.<br>Klik tanda (+) pada kue untuk memilih.</p>

                        </div>

                    @else

                        {{-- Daftar List Belanjaan --}}

                        <div class="mb-3" style="max-height: 200px; overflow-y: auto;">

                            @foreach($pesananAktif->details as $detail)

                            <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom border-light border-opacity-10">

                                <div style="max-width: 65%;">

                                    <span class="fw-semibold text-white d-block small text-truncate">{{ $detail->menu->nama_menu ?? $detail->menu->name }}</span>

                                    <small class="text-white-50">{{ $detail->jumlah }}x @ Rp{{ number_format(($detail->subtotal / $detail->jumlah), 0, ',', '.') }}</small>

                                </div>

                                <div class="d-flex align-items-center gap-2">

                                    <span class="fw-bold text-success small">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>

                                   

                                    <form action="{{ route('keranjang.hapus', $detail->id) }}" method="POST" class="m-0">

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit" class="btn btn-link text-danger p-0 m-0 btn-sm shadow-none"><i class="bi bi-trash3"></i></button>

                                    </form>

                                </div>

                            </div>

                            @endforeach

                        </div>



                        {{-- FORM UTAMA CHECKOUT --}}

                        <form action="{{ route('checkout') }}" method="POST" class="d-block w-100 m-0 p-0">

                            @csrf

                           

                            {{-- 📅 INPUT JADWAL PENGAMBILAN --}}

                            <div class="p-3 rounded mb-3 text-start border border-light border-opacity-10" style="background: rgba(255,255,255,0.06);">

                                <h6 class="fw-bold text-warning small mb-2"><i class="bi bi-calendar-event me-1"></i> Jadwal Pengambilan Kue</h6>

                               

                                <div class="row g-2">

                                    <div class="col-6">

                                        <label class="text-white-50 d-block mb-1" style="font-size: 0.7rem;">Tanggal</label>

                                        {{-- 🌟 TANGGAL DINAMIS VIA BACKEND CONTROLLER 🌟 --}}

                                        <input type="date" id="tanggal_ambil" name="tanggal_ambil" value="{{ old('tanggal_ambil', $hariIni) }}" min="{{ $hariIni }}" required

                                               class="form-control form-control-sm border-0 text-white shadow-none style-input-date">

                                    </div>

                                    <div class="col-6">

                                        <label class="text-white-50 d-block mb-1" style="font-size: 0.7rem;">Jam Ambil</label>

                                        {{-- 🌟 SELECT DROPDOWN SLOT JAM TOKO 🌟 --}}

                                        <select id="jam_ambil" name="jam_ambil" required class="form-select form-select-sm border-0 text-white shadow-none style-input-date">

                                            <option value="">-- Pilih Jam --</option>

                                            @foreach($slotJam as $jam)

                                                <option value="{{ $jam }}" {{ old('jam_ambil') == $jam ? 'selected' : '' }}>{{ $jam }} WIB</option>

                                            @endforeach

                                        </select>

                                    </div>

                                </div>

                            </div>



                            <div class="p-3 rounded mb-3 bg-white bg-opacity-10 border border-light border-opacity-10">

                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="small text-white-50">Total Pembayaran:</span>

                                    <span class="fw-bold text-warning fs-5">Rp {{ number_format($pesananAktif->total_harga, 0, ',', '.') }}</span>

                                </div>

                            </div>



                            <button type="submit" class="btn btn-warning w-100 fw-bold text-dark border-0 py-2 btn-checkout-action" style="border-radius: 10px;">

                                <i class="bi bi-check-all me-1 fs-5 align-middle"></i> Lanjutkan Pemesanan

                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>



{{-- 🌟 BOOTSTRAP TOAST UNTUK POP-UP NOTIFIKASI ELEGAN 🌟 --}}

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1100">

    <div id="toastWaktu" class="toast align-items-center text-white bg-dark border-0 shadow" role="alert" aria-live="assertive" aria-atomic="true" style="border-radius: 10px; background: rgba(30, 41, 59, 0.95) !important; backdrop-filter: blur(8px);">

        <div class="d-flex">

            <div class="toast-body d-flex align-items-center gap-2">

                <i class="bi bi-clock-history text-warning fs-5"></i>

                <span>Pemesanan sudah di atas jam 16.00. Pengambilan dialihkan ke hari selanjutnya dengan slot jam penuh!</span>

            </div>

            <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>

        </div>

    </div>

</div>



<style>

    .object-fit-cover {

        object-fit: cover !important;

    }

    .text-line-clamp {

        display: -webkit-box;

        -webkit-line-clamp: 2;

        -webkit-box-orient: vertical;  

        overflow: hidden;

    }

    .group-card img {

        transition: transform 0.3s ease;

    }

    .group-card:hover img {

        transform: scale(1.05);

    }

    .button-plus:hover {

        background-color: #1b5e20 !important;

        transform: scale(1.05);

        transition: all 0.2s ease;

    }

    .btn-checkout-action {

        transition: all 0.2s ease-in-out;

    }

    .btn-checkout-action:hover {

        background-color: #ffca28 !important;

        transform: translateY(-2px);

        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.4) !important;

    }

    .style-input-date {

        background: rgba(255, 255, 255, 0.15) !important;

        border-radius: 6px !important;

    }

    .style-input-date option {

        background-color: #1e293b !important;

        color: #fff !important;

    }

    .style-input-date::-webkit-calendar-picker-indicator {

        filter: invert(1);

        cursor: pointer;

    }

</style>



{{-- 🧠 JAVASCRIPT VALIDASI JAM DAN TANGGAL PENGAMBILAN REAL-TIME 🧠 --}}

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const inputTanggal = document.getElementById('tanggal_ambil');

        const selectJam = document.getElementById('jam_ambil');

       

        // Inisialisasi Pop-up Elegan Bootstrap Toast

        const toastElemen = document.getElementById('toastWaktu');

        const bsToast = new bootstrap.Toast(toastElemen, { delay: 5000 });

       

        // Menangkap data dari backend Laravel

        const hariIni = "{{ $hariIni }}";

        const jamSekarang = "{{ $jamSekarang }}"; // Format: HH:MM



        function sesuaikanSlotJam(pemicuUser = false) {

            let tanggalDipilih = inputTanggal.value;

            const opsiJam = selectJam.querySelectorAll('option');



            // 🚨 LOGIKA UTAMA: Jika memesan di atas jam 16:00 dan memilih hari ini

            if (jamSekarang > "16:00" && tanggalDipilih === hariIni) {

                const besok = new Date();

                besok.setDate(besok.getDate() + 1);

               

                const formatBesok = besok.toISOString().split('T')[0];

                inputTanggal.value = formatBesok;

                tanggalDipilih = formatBesok; // Alihkan variabel ke tanggal baru

               

                // Tampilkan pop-up toast yang anggun

                bsToast.show();

            }



            let opsiTersedia = 0;



            opsiJam.forEach(option => {

                if (option.value === "") return; // Lewati placeholder



                // JIKA PEMBELI MEMILIH HARI INI (Hanya berlaku jika waktu < 16:00)

                if (tanggalDipilih === hariIni) {

                    if (option.value <= jamSekarang) {

                        option.disabled = true;

                        option.style.display = 'none';

                        if (selectJam.value === option.value) {

                            selectJam.value = ""; // Reset jika jam yang dipilih hangus

                        }

                    } else {

                        option.disabled = false;

                        option.style.display = 'block';

                        opsiTersedia++;

                    }

                } else {

                    // JIKA MEMILIH BESOK ATAU LUSA

                    // Buka semua opsi slot jam (09:00, 12:00, 15:00)

                    option.disabled = false;

                    option.style.display = 'block';

                    opsiTersedia++;

                }

            });



            // Antisipasi jika user memaksa mengubah tanggal kembali ke hari ini lewat datepicker

            if (opsiTersedia === 0 && tanggalDipilih === hariIni) {

                const besok = new Date();

                besok.setDate(besok.getDate() + 1);

                inputTanggal.value = besok.toISOString().split('T')[0];

                bsToast.show();

                sesuaikanSlotJam();

            }

        }



        // Jalankan fungsi filter saat halaman keranjang selesai dimuat

        sesuaikanSlotJam(false);



        // Jalankan fungsi filter setiap kali pembeli mencoba mengubah tanggal pengambilan

        inputTanggal.addEventListener('change', function() {

            sesuaikanSlotJam(true);

        });

    });

</script>

@endsection 

