<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
    /**
     * Menampilkan form untuk mengisi detail pemesanan dan penumpang.
     */
    public function show(Penerbangan $penerbangan, Request $request)
    {
        // Ambil semua parameter pencarian dari URL
        $search = $request->all();

        // Hitung jumlah penumpang dari array 'passengers' di URL
        $passengers_count = ($request->input('passengers.adult') ?? 1) + ($request->input('passengers.child') ?? 0);

        // Ambil kelas penumpang dari URL, default-nya 'Ekonomi'
        $passengerClass = $request->input('passengerClass', 'Ekonomi');
        
        // ==========================================================
        // === INI ADALAH PERBAIKAN FINAL                         ===
        // === Sesuaikan nama view dengan file Anda: index.blade.php ===
        // ==========================================================
        return view('pemesanan.index', compact( // <-- Diubah dari 'show' ke 'index'
            'penerbangan', 
            'passengers_count', 
            'passengerClass', 
            'search'
        ));
    }

    /**
     * Menyimpan data pemesanan dan detail penumpang ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'penerbangan_id' => 'required|exists:penerbangan,id',
            'passengerClass' => 'required|string',
            'passengers' => 'required|array',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.identity_number' => 'required|string|max:50',
            'passengers.*.date_of_birth' => 'required|date',
            'passengers.*.gender' => 'required|string',
        ]);

        try {
            // Gunakan DB Transaction untuk memastikan semua data berhasil disimpan atau tidak sama sekali
            $pemesanan = DB::transaction(function () use ($request) {
                $penerbangan = Penerbangan::findOrFail($request->penerbangan_id);
                $kelas = $penerbangan->kelas()->where('jenis_kelas', $request->passengerClass)->firstOrFail();
                $jumlahPenumpang = count($request->passengers);

                if ($kelas->kuota_kursi < $jumlahPenumpang) {
                    throw new \Exception('Maaf, kursi tidak cukup.');
                }
                
                $pemesanan = Pemesanan::create([
                    'user_id' => Auth::id(),
                    'penerbangan_id' => $penerbangan->id,
                    'kode_booking' => 'TIKETKU-' . strtoupper(Str::random(8)),
                    'total_harga' => $kelas->harga * $jumlahPenumpang,
                    'status_pembayaran' => 'Belum Dibayar',
                ]);

                foreach ($request->passengers as $penumpangData) {
                    $pemesanan->penumpangs()->create([
                        'nama' => $penumpangData['name'],
                        'nomor_identitas' => $penumpangData['identity_number'],
                        'tanggal_lahir' => $penumpangData['date_of_birth'],
                        'jenis_kelamin' => $penumpangData['gender'],
                    ]);
                }

                $kelas->decrement('kuota_kursi', $jumlahPenumpang);

                return $pemesanan;
            });

            return redirect()->route('pembayaran.show', $pemesanan->id);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}