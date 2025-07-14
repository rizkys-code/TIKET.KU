<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbangan;
use App\Models\Maskapai;
use App\Models\Bandara; // <-- PENTING: Tambahkan 'use' statement untuk Bandara
use Carbon\Carbon;

class PenerbanganController extends Controller
{
    /**
     * Menampilkan halaman jadwal penerbangan dengan hasil pencarian.
     */
    public function index(Request $request)
    {
        // ==========================================================
        // === TAMBAHKAN INI: Ambil daftar kota unik dari database ===
        // ==========================================================
        // Query ini akan mengambil semua nama kota yang unik dari tabel bandara
        // dan mengurutkannya secara alfabetis untuk dropdown.
        $cities = Bandara::select('kota')->distinct()->orderBy('kota', 'asc')->get();

        // Ambil semua input pencarian untuk dikirim kembali ke view
        $search = $request->all();
        
        // Mulai query builder untuk Penerbangan
        $query = Penerbangan::query();
        
        // 1. Filter berdasarkan Kota Asal (jika ada)
        if ($request->filled('from')) {
            $query->whereHas('bandaraAsal', function($q) use ($request) {
                $q->where('kota', $request->from);
            });
        }

        // 2. Filter berdasarkan Kota Tujuan (jika ada)
        if ($request->filled('to')) {
            $query->whereHas('bandaraTujuan', function($q) use ($request) {
                $q->where('kota', $request->to);
            });
        }

        // 3. Filter berdasarkan Tanggal Berangkat (jika ada)
        if ($request->filled('date')) {
            try {
                $tanggal = Carbon::createFromFormat('d F Y', $request->date, 'Asia/Jakarta')->format('Y-m-d');
                $query->whereDate('tanggal_berangkat', $tanggal);
            } catch (\Exception $e) {
                // Abaikan jika format tanggal salah
            }
        }

        // 4. Filter berdasarkan Ketersediaan Kelas dan Kursi (jika ada)
        if ($request->filled('passengers')) {
            $passengerCount = ($request->passengers['adult'] ?? 0) + ($request->passengers['child'] ?? 0);
            $passengerClass = $request->passengerClass ?? 'Ekonomi';

            $query->whereHas('kelas', function($q) use ($passengerClass, $passengerCount) {
                $q->where('jenis_kelas', $passengerClass)
                  ->where('kuota_kursi', '>=', $passengerCount);
            });
        }
        
        // Ambil ID maskapai yang tersedia dari hasil query saat ini
        $available_airline_ids = $query->clone()->pluck('maskapai_id')->unique();
        
        // Ambil data lengkap maskapai tersebut untuk ditampilkan di dropdown
        $flights_for_filter = Maskapai::whereIn('id', $available_airline_ids)->orderBy('nama_maskapai')->get();

        // SEKARANG, terapkan filter maskapai yang dipilih dari dropdown (jika ada)
        if ($request->filled('airline_filter')) {
            $query->where('maskapai_id', $request->airline_filter);
        }
        
        // Eager load relasi untuk menghindari N+1 problem & lakukan pagination
        $flights = $query->with(['maskapai', 'bandaraAsal', 'bandaraTujuan', 'kelas'])->paginate(10);
        
        // ==========================================================
        // === UBAH INI: Tambahkan 'cities' ke dalam compact()      ===
        // ==========================================================
        // Sekarang, variabel $cities akan tersedia di dalam view Anda.
        return view('penerbangan.jadwal', compact('flights', 'search', 'flights_for_filter', 'cities'));
    }
}