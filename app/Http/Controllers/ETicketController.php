<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // <-- PENTING: Import PDF Facade

class ETicketController extends Controller
{
    /**
     * Menghasilkan dan mengunduh E-Tiket dalam format PDF.
     */
    public function download(Pemesanan $pemesanan)
    {
        // Keamanan: Pastikan hanya pemilik tiket yang bisa mengunduh
        abort_if($pemesanan->user_id !== Auth::id(), 403, 'Akses Ditolak');

        // Memuat semua data relasi yang kita butuhkan untuk ditampilkan di tiket
        $pemesanan->load([
            'penumpangs', 
            'penerbangan.maskapai', 
            'penerbangan.bandaraAsal', 
            'penerbangan.bandaraTujuan'
        ]);

        // Membuat PDF dari sebuah Blade view
        // Kita akan membuat view 'eticket.pdf' di langkah berikutnya
        $pdf = PDF::loadView('eticket.pdf', compact('pemesanan'));

        // Menentukan nama file saat diunduh
        $namaFile = 'E-Tiket-' . $pemesanan->kode_booking . '.pdf';

        // Mengunduh file PDF
        return $pdf->download($namaFile);
    }
}