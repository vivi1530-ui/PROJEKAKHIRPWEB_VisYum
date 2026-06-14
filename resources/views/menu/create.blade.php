@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-success text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}" class="text-success text-decoration-none">Daftar Menu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Jajanan</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-success text-white p-4" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-plus-circle-fill fs-3 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Tambah Menu Jajanan Baru</h4>
                            <small>Pastikan semua data terisi dengan benar untuk stok kantin.</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        
                        <input type="hidden" name="kode_menu" value="OTOMATIS">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kategori Jajanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-tag-fill"></i></span>
                                {{-- MODIFIKASI TRANSPARAN DI SINI --}}
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" 
                                        style="background-color: rgba(255, 255, 255, 0.15) !important; color: #ffffff !important; backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                                    <option value="" selected disabled style="color: #6c757d; background-color: #343a40;">-- Pilih Kategori Jajanan Tradisional --</option>
                                    @foreach($categories as $kategori)
                                        <option value="{{ $kategori->id }}" {{ old('category_id') == $kategori->id ? 'selected' : '' }} style="color: #ffffff; background-color: #343a40;">
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">Pilih kelompok jajanan tradisional yang sesuai.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Jajanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-egg-fried"></i></span>
                                <input type="text" name="nama_menu" 
                                       class="form-control @error('nama_menu') is-invalid @enderror" 
                                       value="{{ old('nama_menu') }}" placeholder="Contoh: Cireng Bumbu Rujak">
                                @error('nama_menu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-dark">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" name="harga" 
                                           class="form-control @error('harga') is-invalid @enderror" 
                                           value="{{ old('harga') }}" placeholder="0">
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-dark">Stok Awal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" name="stok" 
                                           class="form-control @error('stok') is-invalid @enderror" 
                                           value="{{ old('stok') }}" placeholder="0">
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Foto Jajanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-image"></i></span>
                                <input type="file" name="foto" 
                                       class="form-control @error('foto') is-invalid @enderror">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">Format yang didukung: JPG, JPEG, PNG. Maksimal 2MB.</div>
                        </div>

                        
                        <hr class="my-4 text-muted">

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('menu.index') }}" class="btn btn-link text-secondary text-decoration-none p-0">
                                <i class="bi bi-arrow-left"></i> Kembali ke Daftar
                            </a>
                            <button type="submit" class="btn btn-success px-5 py-2 shadow-sm fw-bold">
                                <i class="bi bi-save2"></i> Simpan Menu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link class="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endsection