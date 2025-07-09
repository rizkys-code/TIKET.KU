<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbangan;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function show(Request $request, Penerbangan $penerbangan)
    {
        $penerbangan->load('maskapai', 'bandaraAsal', 'bandaraTujuan');

        $passengers = $request->input('passengers', ['adult' => 1, 'child' => 0, 'infant' => 0]);
        $passengers_count = (int) ($passengers['adult'] ?? 0) + (int) ($passengers['child'] ?? 0) + (int) ($passengers['infant'] ?? 0);
        if ($passengers_count < 1) {
            $passengers_count = 1;
        }

        $passengerClass = $request->input('passengerClass', 'Ekonomi');

        return view('pemesanan.index', [
            'penerbangan' => $penerbangan,
            'passengers_count' => $passengers_count,
            'passengerClass' => $passengerClass,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'penerbangan_id' => 'required|exists:penerbangan,id',
            'passengerClass' => 'required|string|in:Ekonomi,Bisnis,First Class',
            'passengers' => 'required|array',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.identity_number' => 'required|string|max:50',
            'passengers.*.date_of_birth' => 'required|date',
            'passengers.*.gender' => 'required|in:Laki-laki,Perempuan',
        ]);

        try {
            DB::beginTransaction();

            $kelasPenerbangan = DB::table('kelas_penerbangan')
                ->where('penerbangan_id', $validated['penerbangan_id'])
                ->where('jenis_kelas', $validated['passengerClass'])
                ->first();

            if (!$kelasPenerbangan) {
                return back()->with('error', 'Kelas penerbangan tidak tersedia.');
            }

            foreach ($validated['passengers'] as $penumpang) {
                Pemesanan::create([
                    'kelas_penerbangan_id' => $kelasPenerbangan->id,
                    'user_id' => Auth::id(),
                    'waktu_pemesanan' => now(),
                    'status' => false,
                    'total_harga' => $kelasPenerbangan->harga,
                    'nama_penumpang' => $penumpang['name'],
                    'nomor_identitas' => $penumpang['identity_number'],
                    'tanggal_lahir' => $penumpang['date_of_birth'],
                    'jenis_kelamin' => $penumpang['gender'],
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }

        return redirect()->route('jadwal')->with('success', 'Pemesanan berhasil dibuat! Silakan lanjutkan ke pembayaran.');
    }
}
