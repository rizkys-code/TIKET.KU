<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenerbanganController extends Controller
{
    /**
     * Menampilkan dan memfilter jadwal penerbangan.
     * Ini adalah method UTAMA yang dijalankan oleh rute '/jadwal'.
     * SEMUA LOGIKA YANG SALAH SUDAH DIPERBAIKI DI SINI.
     */
    public function index(Request $request)
    {
        // WAJIB: Mengatur bahasa Carbon ke Indonesia agar mengerti bulan "Juli", "Agustus", dll.
        Carbon::setLocale('id');

        // Mengambil semua parameter pencarian untuk dikirim kembali ke view
        $search = $request->all();

        // Query dasar dengan eager loading untuk optimasi
        $query = Penerbangan::query()->with(['maskapai', 'bandaraAsal', 'bandaraTujuan', 'kelas']);

        // Filter berdasarkan 'from' (asal) yang lebih akurat
        // Mencari berdasarkan nama kota ATAU nama bandara
        if ($request->filled('from')) {
            $query->whereHas('bandaraAsal', function ($q) use ($request) {
                $q->where('kota', 'like', '%' . $request->from . '%')
                  ->orWhere('nama_bandara', 'like', '%' . $request->from . '%');
            });
        }

        // Filter berdasarkan 'to' (tujuan) yang lebih akurat
        if ($request->filled('to')) {
            $query->whereHas('bandaraTujuan', function ($q) use ($request) {
                $q->where('kota', 'like', '%' . $request->to . '%')
                  ->orWhere('nama_bandara', 'like', '%' . $request->to . '%');
            });
        }

        // =========================================================================
        // PERBAIKAN UTAMA: LOGIKA PEMBERSIH DAN FILTER TANGGAL
        // =========================================================================
        if ($request->filled('date')) {
            try {
                // Coba konversi tanggal dari format 'd F Y' (contoh: 17 Juli 2025).
                // Jika berhasil, gunakan untuk filter.
                $tanggal = Carbon::createFromFormat('d F Y', $request->date)->format('Y-m-d');
                $query->whereDate('waktu_berangkat', $tanggal);
            } catch (\Exception $e) {
                // Jika GAGAL (karena inputnya 'aN undefined NaN' atau format lain yang aneh),
                // kita tidak melakukan apa-apa pada query,
                // DAN kita 'bersihkan' data yang akan dikirim kembali ke view.
                // INI YANG MEMUTUS LINGKARAN SETAN BUG-NYA.
                $search['date'] = '';
            }
        }
        // =========================================================================

        // Ambil data untuk dropdown filter maskapai SEBELUM paginasi
        // Menggunakan clone() agar query utama tidak terpengaruh
        $flights_for_filter = (clone $query)->get();

        // Filter tambahan berdasarkan maskapai jika dipilih
        if ($request->filled('airline_filter')) {
            $query->where('maskapai_id', $request->airline_filter);
        }

        // Eksekusi query akhir: urutkan dari yang paling pagi, lalu paginasi
        $flights = $query->orderBy('waktu_berangkat', 'asc')->paginate(10);

        // Kirim semua data yang dibutuhkan ke view
        return view('penerbangan.jadwal', compact('flights', 'flights_for_filter', 'search'));
    }
}