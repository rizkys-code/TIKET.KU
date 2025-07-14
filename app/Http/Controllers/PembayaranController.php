<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
// ==========================================================
// === LANGKAH 1: Tambahkan use statement ini di atas      ===
// ==========================================================
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Menampilkan halaman detail pembayaran.
     * Menggunakan Route-Model Binding untuk otomatis mencari pemesanan.
     */
    public function show(Pemesanan $pemesanan)
    {
        // ==========================================================
        // === LANGKAH 2: Ganti dengan Auth::id()                 ===
        // ==========================================================
        // Pastikan pemesanan ini milik user yang sedang login
        abort_if($pemesanan->user_id !== Auth::id(), 403, 'Akses Ditolak');
        
        // Eager load relasi yang dibutuhkan di view untuk efisiensi
        $pemesanan->load(['penumpangs', 'penerbangan.maskapai', 'penerbangan.bandaraAsal', 'penerbangan.bandaraTujuan']);

        return view('pembayaran.show', compact('pemesanan'));
    }

    /**
     * Memproses pembayaran (simulasi).
     */
    public function process(Pemesanan $pemesanan)
    {
        // ==========================================================
        // === LANGKAH 2: Ganti dengan Auth::id()                 ===
        // ==========================================================
        // Pastikan pemesanan ini milik user yang sedang login
        abort_if($pemesanan->user_id !== Auth::id(), 403, 'Akses Ditolak');

        // Di aplikasi nyata, di sini ada logika integrasi dengan payment gateway.
        // Untuk simulasi, kita langsung ubah statusnya.
        $pemesanan->update([
            'status_pembayaran' => 'Lunas'
        ]);

        // Redirect kembali ke halaman pembayaran dengan pesan sukses
        return redirect()->route('pembayaran.show', $pemesanan->id)
                         ->with('success', 'Pembayaran Anda telah berhasil dikonfirmasi!');
    }
}