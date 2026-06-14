@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-white border-0 pt-4 ps-4">
                    <h4 class="fw-bold text-success"><i class="bi bi-gear-fill"></i> Pengaturan Preferensi</h4>
                </div>
                <div class="card-body p-4">
                    <form id="settings-form">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Tema Halaman</label>
                            <select name="theme" id="theme-select" class="form-select border-success-subtle">
                                <option value="light" {{ request()->cookie('theme', 'light') == 'light' ? 'selected' : '' }}>Terang (Light)</option>
                                <option value="dark" {{ request()->cookie('theme') == 'dark' ? 'selected' : '' }}>Gelap (Dark)</option>
                                <option value="system" {{ request()->cookie('theme') == 'system' ? 'selected' : '' }}>Ikuti Sistem (System)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ukuran Huruf</label>
                            <select name="font_size" id="font-size-select" class="form-select border-success-subtle">
                                <option value="small" {{ request()->cookie('font_size') == 'small' ? 'selected' : '' }}>Kecil</option>
                                <option value="medium" {{ request()->cookie('font_size', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                <option value="large" {{ request()->cookie('font_size') == 'large' ? 'selected' : '' }}>Besar</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                            <i class="bi bi-cloud-check"></i> Simpan Perubahan
                        </button>
                    </form>
                    
                    <div id="response-msg" class="mt-3 text-center small d-none alert alert-success border-0 py-2" style="border-radius: 8px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('settings-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const theme = document.getElementById('theme-select').value;
    const fontSize = document.getElementById('font-size-select').value;
    const msgDiv = document.getElementById('response-msg');

    try {
        // Poin 3f: Fetch POST ke endpoint Laravel
        const response = await fetch("{{ route('settings.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ theme, font_size: fontSize })
        });

        const result = await response.json();

        if(result.success) {
            // Memunculkan pesan sukses cetakan JSON dari Controller
            msgDiv.classList.remove('d-none');
            msgDiv.innerText = result.message;

            // Catatan: Cookie otomatis di-set oleh response dari Laravel (SettingsController)
            // Cukup lakukan reload halaman setelah jeda agar tema baru langsung teraplikasi
            setTimeout(() => {
                location.reload();
            }, 800);
        }
    } catch (error) {
        console.error("Gagal menyimpan preferensi:", error);
    }
});
</script>
@endsection