<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerbangan;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // <-- TAMBAHKAN BARIS INI

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
        // 1. Validasi tetap sama
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

            // 2. Ambil detail kelas dan hitung total harga untuk SEMUA penumpang
            $penerbangan = Penerbangan::with('kelas')->find($validated['penerbangan_id']);
            $hargaPerPax = $penerbangan->kelas->firstWhere('jenis_kelas', $validated['passengerClass'])->harga ?? 0;

            if ($hargaPerPax == 0) {
                return back()->with('error', 'Kelas penerbangan tidak tersedia atau harga belum diatur.');
            }

            $jumlahPenumpang = count($validated['passengers']);
            $totalHarga = $hargaPerPax * $jumlahPenumpang;

            // 3. Buat SATU catatan pemesanan utama
            $pemesanan = Pemesanan::create([
                'user_id' => Auth::id(),
                'penerbangan_id' => $validated['penerbangan_id'],
                'kode_booking' => 'TIKETKU-' . strtoupper(Str::random(8)), // Sekarang 'Str' sudah dikenali
                'total_harga' => $totalHarga,
                'status_pembayaran' => 'Belum Dibayar',
            ]);
            
            // 4. Simpan setiap penumpang ke tabel terpisah
            foreach ($validated['passengers'] as $passengerData) {
                $pemesanan->penumpangs()->create([
                    'nama' => $passengerData['name'],
                    'nomor_identitas' => $passengerData['identity_number'],
                    'tanggal_lahir' => $passengerData['date_of_birth'],
                    'jenis_kelamin' => $passengerData['gender'],
                ]);
            }

            DB::commit();

            // 5. Alihkan ke halaman pembayaran dengan ID pemesanan yang baru
            return redirect()->route('pembayaran.show', ['id_pemesanan' => $pemesanan->id])
                        ->with('success', 'Detail pesanan berhasil disimpan. Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan: ' . $e->getMessage());
        }
    }
}