<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;
use App\Models\Bandara;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenerbanganController extends Controller
{
    /**
     * Menampilkan dan memfilter jadwal penerbangan.
     * Method ini sekarang menangani semua logika pencarian.
     */
    public function index(Request $request)
    {
        // Query dasar, dengan eager loading untuk optimasi
        // Menggunakan model Penerbangan sesuai file Anda
        $query = Penerbangan::with(['maskapai', 'bandaraAsal', 'bandaraTujuan', 'kelas']);

        // ---- Terapkan Filter dari Request ----

        // 1. Filter berdasarkan Kota/Bandara Asal & Tujuan
        if ($request->filled('from')) {
            // Mengambil bagian pertama dari string (misal: "Jakarta" dari "Jakarta, CGK")
            $fromCity = explode(',', $request->from)[0];
            $fromAirportId = Bandara::where('nama_kota', 'like', '%' . $fromCity . '%')
                ->orWhere('kode_bandara', 'like', '%' . $fromCity . '%')
                ->value('id');
            if ($fromAirportId) {
                $query->where('bandara_asal_id', $fromAirportId);
            }
        }

        if ($request->filled('to')) {
            $toCity = explode(',', $request->to)[0];
            $toAirportId = Bandara::where('nama_kota', 'like', '%' . $toCity . '%')
                ->orWhere('kode_bandara', 'like', '%' . $toCity . '%')
                ->value('id');
            if ($toAirportId) {
                $query->where('bandara_tujuan_id', $toAirportId);
            }
        }

        // 2. Filter berdasarkan Tanggal Keberangkatan
        if ($request->filled('date')) {
            $dateParts = explode(' - ', $request->date);
            try {
                // Konversi tanggal dari format "Sab, 9 Agt 25" ke format Y-m-d
                $departureDate = Carbon::createFromLocaleFormat('D, j M y', 'id', $dateParts[0])->format('Y-m-d');
                $query->whereDate('waktu_berangkat', $departureDate);
            } catch (\Exception $e) {
                // Abaikan jika format tanggal tidak valid
            }
        }

        // 3. Filter berdasarkan Ketersediaan Kelas Kabin
        if ($request->filled('passengerClass')) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('jenis_kelas', $request->passengerClass);
            });
        }

        // Ambil hasil sebelum difilter maskapai untuk mengisi dropdown
        // Ini memastikan dropdown berisi semua maskapai yang cocok dengan rute & tanggal.
        $flights_for_filter = $query->clone()->get();


        // 4. Filter berdasarkan Maskapai (dari dropdown)
        if ($request->filled('airline_filter')) {
            $query->where('maskapai_id', $request->airline_filter);
        }

        // Eksekusi query untuk mendapatkan hasil akhir yang akan ditampilkan
        $flights = $query->orderBy('waktu_berangkat', 'asc')->get();

        // Siapkan data pencarian untuk dikirim kembali ke view (mengisi ulang form)
        $search = [
            'from' => $request->input('from', 'Jakarta, CGK'),
            'to' => $request->input('to', 'Singapore, SIN'),
            'dateText' => $request->input('date', 'Pilih Tanggal'),
            'passengerClass' => $request->input('passengerClass', 'Ekonomi'),
            'passengers' => $request->input('passengers', [
                'adult' => 1,
                'child' => 0,
                'infant' => 0
            ]),
        ];

        return view('penerbangan.jadwal', compact('flights', 'search', 'flights_for_filter'));
    }
}
