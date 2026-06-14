@extends('layouts.app')

@section('content')
<div class="container py-4 text-white">

    {{-- 📊 KARTU STATISTIK PENDAPATAN --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 text-center bg-dark" style="border-radius: 15px; border: 1px solid rgba(25, 135, 84, 0.3) !important;">
                <span class="text-white-50 small d-block mb-1"><i class="bi bi-cash-stack me-1 text-success"></i> Total Pendapatan Omzet (Selesai)</span>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 text-center bg-dark" style="border-radius: 15px; border: 1px solid rgba(255, 193, 7, 0.3) !important;">
                <span class="text-white-50 small d-block mb-1"><i class="bi bi-receipt me-1 text-warning"></i> Total Transaksi Sukses</span>
                <h3 class="fw-bold text-warning mb-0">{{ $totalTransaksi }} Pesanan</h3>
            </div>
        </div>
    </div>

    {{-- 🔍 NAVIGASI FILTER ANTREAN --}}
    <div class="mb-4 p-3 rounded-4" style="background: rgba(255, 193, 7, 0.12); backdrop-filter: blur(10px); border: 1px solid rgba(255, 193, 7, 0.25);">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-funnel-fill text-warning fs-5"></i>
                <span class="fw-bold text-white">Filter Status Antrean:</span>
            </div>
            
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ request()->fullUrlWithQuery(['status_filter' => null]) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status_filter') == null ? 'btn-warning text-dark fw-bold' : 'btn-outline-light' }}">
                    Semua Data
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status_filter' => 'belum_diproses']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status_filter') == 'belum_diproses' ? 'btn-primary text-white fw-bold' : 'btn-outline-primary' }}">
                    🔵 Belum Diproses (Lunas)
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status_filter' => 'sedang_diproses']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status_filter') == 'sedang_diproses' ? 'btn-success text-white fw-bold' : 'btn-outline-success' }}">
                    🟢 Sedang Diproses
                </a>

                <a href="{{ request()->fullUrlWithQuery(['status_filter' => 'selesai']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status_filter') == 'selesai' ? 'btn-secondary text-white fw-bold' : 'btn-outline-secondary' }}">
                    ⚪ Selesai
                </a>
            </div>
        </div>
    </div>

    {{-- 📑 MONITOR UTAMA TABEL ANTREAN --}}
    <div class="card border-0 shadow-sm bg-dark" style="border-radius: 15px;">
        <div class="card-body p-4">
            <h4 class="fw-bold text-white mb-3"><i class="bi bi-card-checklist text-success me-1"></i> Monitor Log & Manajemen Antrean Pesanan</h4>
            
            <div class="table-responsive">
                <table class="table align-middle table-dark">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Detail Jajanan Yang Dibeli</th>
                            <th>Total Bayar</th>
                            <th>Waktu Pembayaran</th>
                            <th>Jadwal Pengambilan</th>
                            <th class="text-center" style="width: 160px;">Status / Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatPesanan as $pesanan)
                            <tr>
                                <td>
                                    <span class="fw-bold d-block text-info">{{ $pesanan->user?->name ?? 'Pelanggan Anonim' }}</span>
                                    <small class="text-white-50">{{ $pesanan->user?->email ?? '-' }}</small>
                                </td>
                                
                                <td>
                                    @if($pesanan->details && $pesanan->details->count() > 0)
                                        @foreach($pesanan->details as $detail)
                                            <div class="small">• {{ $detail->menu?->nama_menu ?? 'Jajanan Telah Dihapus' }} <b class="text-warning">x{{ $detail->jumlah }}</b></div>
                                        @endforeach
                                    @else
                                        <span class="text-white-50 small">Tidak ada detail menu</span>
                                    @endif
                                </td>
                                
                                <td class="fw-bold text-success">Rp {{ number_format($total_harga ?? $pesanan->total_harga, 0, ',', '.') }}</td>
                                
                                {{-- KUNCI WAKTU: Menggunakan created_at agar Jam Pembayaran Terkunci Abadi --}}
                                <td class="small">
                                    @if($pesanan->status !== 'menunggu_pembayaran')
                                        <span class="text-success-emphasis d-block fw-semibold small">
                                            <i class="bi bi-shield-check text-success me-1"></i> Terverifikasi Lunas
                                        </span>
                                        <small class="text-white-50">
                                            {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB
                                        </small>
                                    @else
                                        <span class="badge bg-danger bg-opacity-20 text-danger border border-danger border-opacity-20 rounded-pill px-2 small">
                                            Belum Bayar
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="fw-bold text-warning small">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        {{ $pesanan->tanggal_ambil ? date('d M Y', strtotime($pesanan->tanggal_ambil)) : date('d M Y') }}
                                    </div>
                                    <span class="badge bg-warning text-dark font-monospace mt-1 fw-bold shadow-sm" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        <i class="bi bi-clock-fill me-1"></i>{{ $pesanan->jam_ambil ?? '09:00' }} WIB
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    @if($pesanan->status === '' || empty($pesanan->status))
                                        <form action="{{ route('owner.pesanan.selesai', $pesanan->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success fw-bold w-100 rounded-pill shadow-sm py-2" style="background-color: #198754 !important; border-color: #198754 !important;">
                                                Sudah Diambil
                                            </button>
                                        </form>
                                    @elseif($pesanan->status === 'selesai')
                                        <button class="btn btn-sm btn-secondary fw-bold w-100 rounded-pill py-2 text-white-50" disabled style="cursor: not-allowed; opacity: 0.6;">
                                            Selesai
                                        </button>
                                    @else
                                        <form action="{{ route('owner.pesanan.proses', $pesanan->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary fw-bold w-100 rounded-pill shadow-sm py-2">
                                                Telah Diproses
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-white-50">
                                    <i class="bi bi-clipboard-x display-6 d-block mb-2 text-white-50"></i>
                                    Tidak ada data antrean untuk kategori status ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection