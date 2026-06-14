@extends('layouts.app')

@section('content')
<div class="container py-4 text-white">
    <div class="card border-0 mb-4 p-3 shadow-sm bg-dark">
        <h3 class="fw-bold mb-1 text-warning">🛍️ Riwayat Belanja Saya</h3>
        <p class="text-white-50 mb-0 small">Daftar pesanan jajanan kue kamu di VisYum.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-3 text-dark fw-semibold" style="border-radius: 10px; background-color: #d1e7dd;">
            <i class="bi bi-check-circle-fill me-2 text-success"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-dark" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-dark">
                <thead>
                    <tr>
                        <th class="ps-4">Kode Transaksi</th>
                        <th>Detail Item</th>
                        <th>Total Belanja</th>
                        <th>Waktu Pembayaran</th>
                        <th>Jadwal Pengambilan</th>
                        <th class="text-center">Status Antrean</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $pesanan)
                    <tr>
                        <td class="ps-4 fw-bold text-info">{{ $pesanan->kode_transaksi }}</td>
                        
                        <td>
                            @if($pesanan->details)
                                @foreach($pesanan->details as $detail)
                                    <div class="small text-white-50">• {{ $detail->menu->nama_menu ?? 'Menu Dihapus' }} <span class="text-warning">x{{ $detail->jumlah }}</span></div>
                                @endforeach
                            @endif
                        </td>
                        
                        <td class="fw-bold text-success">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        
                        {{-- KUNCI WAKTU: Menggunakan created_at agar Jam Pembeli Sinkron Selamanya --}}
                        <td class="small text-white-50">
                            @if($pesanan->status !== 'menunggu_pembayaran')
                                <div class="text-white fw-semibold small mb-1">
                                    <i class="bi bi-credit-card-2-back text-success me-1"></i> Sudah Dibayar
                                </div>
                                <span style="font-size: 0.8rem;">
                                    {{ $pesanan->created_at ? $pesanan->created_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB
                                </span>
                            @else
                                <span class="text-danger small fw-semibold">
                                    <i class="bi bi-exclamation-circle me-1"></i> Menunggu Pembayaran
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="fw-bold text-warning small">
                                <i class="bi bi-calendar-event me-1"></i>
                                {{ $pesanan->tanggal_ambil ? date('d M Y', strtotime($pesanan->tanggal_ambil)) : date('d M Y') }}
                            </div>
                            <small class="text-white-50 d-block mt-0.5" style="font-size: 0.8rem;">
                                Kloter: <b class="text-white font-monospace">{{ $pesanan->jam_ambil ?? '09:00' }} WIB</b>
                            </small>
                        </td>
                        
                        <td class="text-center">
                            @if($pesanan->status === 'lunas')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> Menunggu Antrean
                                </span>
                            @elseif($pesanan->status === '' || empty($pesanan->status))
                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-bag-check-fill me-1"></i> Ambil Pesanan
                                </span>
                            @elseif($pesanan->status === 'selesai')
                                <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Selesai
                                </span>
                            @elseif($pesanan->status === 'menunggu_pembayaran')
                                <span class="badge bg-danger text-white px-3 py-2 rounded-pill shadow-sm fw-bold">
                                    <i class="bi bi-wallet2 me-1"></i> Belum Bayar
                                </span>
                            @else
                                <span class="badge bg-secondary text-white px-3 py-2 rounded-pill shadow-sm fw-bold">
                                    {{ $pesanan->status }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-white-50">
                            <i class="bi bi-cart-x display-4 mb-2 d-block text-muted"></i>
                            Kamu belum memiliki riwayat pemesanan kue.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection