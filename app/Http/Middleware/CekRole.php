<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login, kalau belum lempar ke halaman login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role user yang login ada di dalam daftar role yang diizinkan
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // 3. 🟢 DIUBAH: Jika pembeli nekat masuk ke rute khusus owner (seperti /menu/create),
        // kita langsung kunci dengan eror 403 (Forbidden) agar browser tidak looping pusing.
        abort(403, 'Maaf, kamu tidak punya akses ke halaman tersebut!');
    }
}