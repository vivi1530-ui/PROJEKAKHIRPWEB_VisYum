@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-success text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('menu.index') }}" class="text-success text-decoration-none">Daftar Menu</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Menu</li>
                </ol>
            </nav>

            {{-- NOTIFIKASI ERROR GLOBAL --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert" style="border-radius: 10px;">
                    <div class="fw-bold text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Gagal Menyimpan Perubahan!</div>
                    <ul class="mb-0 mt-1 small text-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-warning text-dark p-4" style="border-radius: 15px 15px 0 0;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-pencil-square fs-3 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Edit Menu Jajanan</h4>
                            <small>Mengubah data: <strong>{{ $menu->nama_menu }}</strong></small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 

                        {{-- 1. KODE MENU --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted">Kode Menu (Tidak dapat diubah)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                                <input type="text" name="kode_menu" class="form-control bg-light" value="{{ old('kode_menu', $menu->kode_menu) }}" readonly>
                            </div>
                        </div>

                        {{-- 2. NAMA JAJANAN --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Nama Jajanan</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-egg-fried"></i></span>
                                <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror" value="{{ old('nama_menu', $menu->nama_menu) }}">
                                @error('nama_menu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 3. KATEGORI JAJANAN (MODIFIKASI TRANSPARAN DI SINI) --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Kategori Tradisional</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-tags-fill"></i></span>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" 
                                        style="background-color: rgba(255, 255, 255, 0.15) !important; color: #ffffff !important; backdrop-filter: blur(5px); border: 1px solid rgba(255, 255, 255, 0.3);">
                                    <option value="" disabled style="color: #6c757d; background-color: #343a40;">-- Pilih Kategori Jajanan --</option>
                                    
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" style="color: #ffffff; background-color: #343a40;" @if(old('category_id', $menu->category_id) == $category->id) selected @endif>
                                            {{ $category->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- 4. HARGA & STOK --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-dark">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">Rp</span>
                                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $menu->harga) }}">
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-dark">Stok</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-box-seam"></i></span>
                                    <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $menu->stok) }}">
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 5. FOTO JAJANAN --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Foto Jajanan</label>
                            
                            @if($menu->foto)
                                <div class="mb-3">
                                    <small class="text-muted d-block mb-2"><i class="bi bi-image"></i> Foto Saat Ini:</small>
                                    <img src="{{ asset('uploads/menu/' . $menu->foto) }}" alt="Foto {{ $menu->nama_menu }}" class="img-thumbnail shadow-sm" style="max-width: 150px; max-height: 150px; object-fit: cover; border-radius: 10px;">
                                </div>
                            @endif

                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-upload"></i></span>
                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-muted">Pilih file baru jika ingin mengganti foto jajanan. Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB).</div>
                        </div>

                        <hr class="my-4 text-muted">

                        {{-- 6. TOMBOL AKSI --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('menu.index') }}" class="btn btn-link text-secondary text-decoration-none p-0">
                                <i class="bi bi-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm fw-bold">
                                <i class="bi bi-check2-circle"></i> Simpan Perubahan
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