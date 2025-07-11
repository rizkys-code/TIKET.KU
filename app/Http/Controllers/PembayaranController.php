<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Menampilkan halaman pembayaran untuk pemesanan tertentu.
     */
    public function show($id_pemesanan)
    {
        // Ambil data pemesanan berdasarkan ID, beserta relasi penerbangan
        // dan relasi-relasi di dalamnya (maskapai, bandara)
        $pemesanan = Pemesanan::with([
            'penerbangan.maskapai',
            'penerbangan.bandaraAsal',
            'penerbangan.bandaraTujuan'
        ])->findOrFail($id_pemesanan);

        // Tampilkan view pembayaran dan kirim data pemesanan
        return view('pembayaran.show', compact('pemesanan'));
    }

    /**
     * Memproses pembayaran (simulasi).
     */
    public function processPayment($id_pemesanan)
    {
        // Cari pemesanan berdasarkan ID
        $pemesanan = Pemesanan::findOrFail($id_pemesanan);

        // Logika untuk mengubah status pembayaran
        // Dalam aplikasi nyata, ini akan melibatkan integrasi dengan payment gateway
        $pemesanan->status_pembayaran = 'Lunas';
        $pemesanan->save();

        // Redirect kembali ke halaman pembayaran dengan pesan sukses
        return redirect()->route('pembayaran.show', $pemesanan->id)
                ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}