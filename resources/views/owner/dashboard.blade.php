@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 10px; background: rgba(40, 167, 69, 0.25); backdrop-filter: blur(8px); color: #fff;">
            <i class="bi bi-check-circle-fill me-2 text-success"></i><strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow h-100 p-4 text-white" 
                 style="border-radius: 15px; background: rgba(255, 255, 255, 0.18) !important; backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.2) !important;">
                <h3 class="fw-bold mb-1" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">Selamat Datang Kembali, Owner Vi! 🍳</h3>
                <p class="text-white small mb-3" style="opacity: 0.85;">Saatnya kembali kelola operasional toko jajanan tradisional kamu.</p>
                
                <hr class="border-white border-opacity-50 my-2">
                
                <div class="d-flex align-items-center justify-content-between mt-2">
                    <div>
                        <h6 class="fw-bold text-warning mb-0" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);"><i class="bi bi-cloud-sun-fill me-1"></i> Info Cuaca Terkini Kantin</h6>
                        <small id="weather-desc" class="text-white text-capitalize" style="opacity: 0.8;">Memuat kondisi langit...</small>
                    </div>
                    <div class="text-end">
                        <span id="weather-temp" class="fs-3 fw-bold text-white">0</span><span class="fs-5 fw-bold text-white">°C</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow h-100 p-4 text-white" 
                 style="border-radius: 15px; background: rgba(13, 110, 253, 0.3) !important; backdrop-filter: blur(12px); border: 1px solid rgba(13, 110, 253, 0.35) !important;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="fw-bold text-info mb-1" style="color: #6ea8fe !important; text-shadow: 0 1px 3px rgba(0,0,0,0.2);"><i class="bi bi-eye-fill me-1"></i> Kunjungan Menu Jajanan</h6>
                        {{-- FIX PENYINKRONAN: Menggunakan variabel terkirim dari controller agar hasil reset langsung terlihat nyata --}}
                        <h3 class="fw-extrabold mb-0 text-white" style="font-size: 2rem;">{{ $kunjunganWeb }} <span class="fs-6 fw-normal text-white" style="opacity: 0.8;">Kali Dilihat</span></h3>
                    </div>
                    <form action="{{ route('menu.reset_session') }}" method="POST" onsubmit="return confirm('Reset statistik kunjungan?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light border-opacity-50 rounded-pill px-2 py-0" style="font-size: 0.75rem; background: rgba(255,255,255,0.1);">Reset</button>
                    </form>
                </div>
                <div class="mt-3 pt-2 border-top border-white border-opacity-20 row text-center g-1" style="font-size: 0.75rem;">
                    {{-- FIX PENYINKRONAN: Menggunakan variabel kiriman agar sinkronisasi jam reset aman --}}
                    <div class="col-6 border-end border-white border-opacity-20">Mulai: <b class="text-white d-block mt-1">{{ $kunjungan_pertama }}</b></div>
                    <div class="col-6">Akhir: <b class="text-white d-block mt-1">{{ $kunjungan_terakhir }}</b></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow h-100 p-4 text-white" 
                 style="border-radius: 15px; background: rgba(220, 53, 69, 0.3) !important; backdrop-filter: blur(12px); border: 1px solid rgba(220, 53, 69, 0.35) !important;">
                <span class="text-white small d-block mb-2 fw-bold" style="color: #ff6b6b !important; text-shadow: 0 1px 3px rgba(0,0,0,0.2);"><i class="bi bi-exclamation-triangle-fill me-1"></i> Peringatan Stok (&lt; 10)</span>
                @if($stokMenipis->isEmpty())
                    <div class="text-center py-4 text-white small" style="opacity: 0.9;">Semua stok kue aman terkendali! 👍</div>
                @else
                    <div style="max-height: 110px; overflow-y: auto; font-size: 0.85rem;">
                        @foreach($stokMenipis as $stokKue)
                            <div class="d-flex justify-content-between border-bottom border-white border-opacity-20 py-2">
                                <span class="text-white">• {{ $stokKue->nama_menu }}</span>
                                <span class="badge bg-danger text-white fw-bold shadow-sm" style="background-color: #dc3545 !important;">{{ $stokKue->stok }} pcs</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card border-0 shadow p-4 text-center mb-4 text-white" 
         style="border-radius: 15px; background: rgba(255, 255, 255, 0.12) !important; backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.15) !important;">
        <h5 class="fw-bold text-white mb-2">💡 Operasional Dapur Siap Beraksi!</h5>
        <p class="text-white small mb-0" style="opacity: 0.85;">Di bawah ini adalah log pesanan masuk. Klik menu <b>Pesanan</b> di bilah navigasi atas untuk mengubah status pengerjaan dapur atau memantau laporan laba omzet masuk.</p>
    </div>

    <div class="card border-0 shadow p-4" style="border-radius: 15px; background: rgba(255, 255, 255, 0.06) !important; backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.1) !important;">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-success fs-5"></i>
                <h5 class="fw-bold text-white mb-0">Daftar Masuk Pesanan</h5>
            </div>
            <a href="{{ route('owner.pesanan') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 fw-semibold" style="font-size: 0.8rem; background: rgba(255,255,255,0.05);">Kelola Antrean</a>
        </div>

        @if($listPesanan->isEmpty())
            <p class="text-white-50 text-center my-4 small">Belum ada data transaksi/pesanan yang masuk ke sistem.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="color: #ffffff;">
                    <thead>
                        <tr class="border-bottom border-white border-opacity-10" style="font-size: 0.9rem;">
                            <th class="pb-3 text-white-50">ID</th>
                            <th class="pb-3 text-white-50">Pelanggan</th>
                            <th class="pb-3 text-white-50">Waktu Pembayaran</th>
                            <th class="pb-3 text-white-50">Total Bayar</th>
                            <th class="pb-3 text-white-50">Jadwal Pengambilan</th>
                            <th class="pb-3 text-center text-white-50">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listPesanan as $pesanan)
                            <tr class="border-bottom border-white border-opacity-5" style="font-size: 0.85rem;">
                                <td class="fw-bold text-white">#{{ $pesanan->id }}</td>
                                <td>{{ $pesanan->user->name ?? 'Pembeli Umum' }}</td>
                                
                                <td>
                                    {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB
                                </td>
                                
                                <td class="fw-semibold text-warning">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                                
                                <td>
                                    <div class="small text-white opacity-90 fw-medium">
                                        <i class="bi bi-calendar-check text-warning me-1"></i>{{ $pesanan->tanggal_ambil ? date('d M Y', strtotime($pesanan->tanggal_ambil)) : date('d M Y') }}
                                    </div>
                                    <span class="badge bg-warning text-dark font-monospace mt-1 fw-bold shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-clock-fill me-1"></i>{{ $pesanan->jam_ambil ?? '09:00' }} WIB
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($pesanan->status === 'selesai')
                                        <span class="badge bg-success bg-opacity-75 rounded-pill px-3 py-1">Selesai</span>
                                    @elseif($pesanan->status === 'proses')
                                        <span class="badge bg-primary bg-opacity-75 rounded-pill px-3 py-1">Diproses</span>
                                    @else
                                        <span class="badge bg-warning text-dark bg-opacity-75 rounded-pill px-3 py-1">Antrean / Lunas</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        try {
            const response = await fetch('https://wttr.in/Jember?format=j1');
            if (!response.ok) throw new Error('API Error');
            const data = await response.json();
            const current = data.current_condition[0];
            
            document.getElementById('weather-temp').innerText = current.temp_C;
            document.getElementById('weather-desc').innerText = current.weatherDesc[0].value;
        } catch (error) {
            document.getElementById('weather-desc').innerText = 'Gagal memuat cuaca';
        }
    });
</script>
@endsection