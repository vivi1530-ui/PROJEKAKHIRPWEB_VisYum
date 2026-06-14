@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            {{-- Glassmorphism gelap --}}
            <div class="card border-0 shadow-lg text-center p-4 text-white" 
                 style="border-radius: 20px; background: rgba(15, 23, 42, 0.55) !important; backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.15) !important;">
                
                <div class="mb-3">
                    <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: rgba(255, 193, 7, 0.2); color: #ffca28; border: 1px solid rgba(255, 193, 7, 0.3);">
                        <i class="bi bi-wallet2 me-1"></i> SELESAIKAN PEMBAYARAN
                    </span>
                </div>
                
                <h4 class="fw-bold text-white mb-1">Simulasi Pembayaran QRIS</h4>
                <p class="text-white-50 small">VY-VisYum Digital Snack Bar</p>
                
                <div class="rounded-3 py-3 px-2 mb-4 border border-light border-opacity-10" style="background: rgba(255, 255, 255, 0.08);">
                    <small class="text-white-50 d-block mb-1">TOTAL YANG HARUS DIBAYAR</small>
                    <h2 class="fw-bold text-warning mb-0">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h2>
                </div>

                {{-- Wadah Barcode QRIS --}}
                <div class="p-3 bg-white border inline-block mx-auto shadow-sm mb-3" style="width: 240px; border-radius: 15px;">
                    <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS Barcode" class="img-fluid rounded-2" onerror="this.src='https://placehold.co/200x200?text=Foto+Barcode+QRIS'">
                </div>
                
                <p class="text-white-50 small px-3 mb-4">Silakan scan kode QR di atas menggunakan aplikasi e-wallet favoritmu untuk simulasi pembayaran instan.</p>
                
                <hr class="my-4 border-light border-opacity-10">

                {{-- TOMBOL AKSI --}}
                <div class="d-flex flex-column gap-2">
                    <form action="{{ route('pembayaran.konfirmasi', $pesanan->id) }}" method="POST" class="w-100 m-0">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 py-2.5 rounded-pill fw-bold shadow border-0 btn-action-success" style="background: #2e7d32 !important;">
                            <i class="bi bi-check-circle-fill me-2"></i> Saya Sudah Selesai Bayar
                        </button>
                    </form>

                    {{-- Tombol Batal Kembali Ke Keranjang (DB dijamin tetap bersih) --}}
                    <a href="{{ route('keranjang.index') }}" class="btn btn-outline-light w-100 py-2.5 rounded-pill fw-semibold text-white-50 border-light border-opacity-25" style="transition: all 0.2s;">
                        <i class="bi bi-arrow-left-short me-1"></i> Kembali ke Keranjang / Batal
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .btn-action-success {
        transition: all 0.2s ease-in-out;
    }
    .btn-action-success:hover {
        background-color: #1b5e20 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.4) !important;
    }
</style>
@endsection