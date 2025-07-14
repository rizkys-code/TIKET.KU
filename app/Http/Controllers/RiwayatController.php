<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Menampilkan halaman riwayat pemesanan milik pengguna yang sedang login.
     */
    public function index()
    {
        // 1. Ambil pemesanan milik user yang sedang login
        $query = Pemesanan::where('user_id', Auth::id());

        // ==========================================================
        // === INI BAGIAN PENTING UNTUK MENGATASI ERROR 'ON NULL' ===
        // ==========================================================
        // Memastikan kita hanya mengambil pemesanan yang data penerbangannya valid
        $query->whereHas('penerbangan');

        // 2. Lanjutkan dengan Eager Loading, urutan, dan paginasi
        $pemesanan = $query->with([
                'penerbangan.maskapai', 
                'penerbangan.bandaraAsal', 
                'penerbangan.bandaraTujuan'
            ])
            ->latest() // Mengurutkan berdasarkan 'created_at' dari yang terbaru
            ->paginate(10); // Menampilkan 10 item per halaman

        // 3. Kirim data ke view
        return view('riwayat.index', compact('pemesanan'));
    }
}