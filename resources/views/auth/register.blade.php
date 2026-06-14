@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(25, 40, 30, 0.45) !important; backdrop-filter: blur(15px) saturate(120%); -webkit-backdrop-filter: blur(15px) saturate(120%); border: 1px solid rgba(255, 255, 255, 0.15) !important;">
                
                <div class="card-header border-0 text-center pt-4 pb-2 bg-transparent">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-25 rounded-circle p-3 mb-2" style="width: 60px; height: 60px; border: 1px solid rgba(255,255,255,0.2);">
                        <i class="bi bi-person-plus-fill text-warning fs-3"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-1" style="text-shadow: 0 2px 4px rgba(0,0,0,0.4);">Daftar Akun Vi's Yum</h3>
                    <p class="text-white-50 small mb-0">Buat akun barumu untuk mulai menjelajahi kelezatan kue pasar</p>
                </div>

                <div class="card-body px-4 pt-3 pb-4">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small shadow-sm border-0 mb-3" style="background: rgba(220, 53, 69, 0.2); color: #ff8787; border-radius: 10px;">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li class="fw-semibold">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label small fw-bold text-white-50 mb-1">Nama Lengkap</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text border-0 text-white-50" style="background: rgba(255,255,255,0.1);"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="name" class="form-control border-0 text-white placeholder-white-50" placeholder="Nama lengkap kamu" value="{{ old('name') }}" required autofocus style="background: rgba(255,255,255,0.08) !important;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label small fw-bold text-white-50 mb-1">Alamat Email</label>
                            <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                <span class="input-group-text border-0 text-white-50" style="background: rgba(255,255,255,0.1);"><i class="bi bi-envelope-fill"></i></span>
                                <input type="email" name="email" id="email" class="form-control border-0 text-white placeholder-white-50" placeholder="nama@email.com" value="{{ old('email') }}" required style="background: rgba(255,255,255,0.08) !important;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label small fw-bold text-white-50 mb-1">Kata Sandi</label>
                                <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                    <span class="input-group-text border-0 text-white-50" style="background: rgba(255,255,255,0.1);"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password" id="password" class="form-control border-0 text-white placeholder-white-50" placeholder="••••••••" required style="background: rgba(255,255,255,0.08) !important;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label small fw-bold text-white-50 mb-1">Ulangi Sandi</label>
                                <div class="input-group shadow-sm" style="border-radius: 10px; overflow: hidden;">
                                    <span class="input-group-text border-0 text-white-50" style="background: rgba(255,255,255,0.1);"><i class="bi bi-shield-check"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-0 text-white placeholder-white-50" placeholder="••••••••" required style="background: rgba(255,255,255,0.08) !important;">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-3">
                            <button type="submit" class="btn btn-success fw-bold rounded-pill shadow py-2.5" style="background: #2e7d32 !important; border: none; transition: all 0.2s ease;">
                                <i class="bi bi-pencil-square me-1"></i> Daftar Akun Sekarang
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer border-0 justify-content-center py-3 text-center" style="background: rgba(0, 0, 0, 0.25);">
                    <span class="small text-white-50 fw-medium">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-warning fw-bold text-decoration-none">Masuk di Sini</a>
                    </span>
                </div>

            </div>
            
        </div>
    </div>
</div>

<style>
    /* Sinkronisasi placeholder form */
    .placeholder-white-50::placeholder {
        color: rgba(255, 255, 255, 0.4) !important;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25) !important;
        background: rgba(255, 255, 255, 0.15) !important;
        color: white !important;
    }
</style>
@endsection