<?php

namespace App\Http\Controllers;

use App\Models\Penerbangan;
use Illuminate\Http\Request;

class PenerbanganController extends Controller
{
    public function index(Request $request)
    {
        $flights = Penerbangan::with(['maskapai', 'bandaraAsal', 'bandaraTujuan', 'kelas'])->get();

        $search = [
            'from' => 'Jakarta, CGK',
            'to' => 'Singapore, SIN',
            'dateText' => 'Sabtu, 9 Agt 25 - Rabu, 13 Agt 25 (Pulang Pergi)',
            'passengerClass' => 'Ekonomi',
            'passengers' => [
                'adult' => 1,
                'child' => 0,
                'infant' => 0,
            ],
        ];

        return view('penerbangan.jadwal', compact('flights', 'search'));
    }
}
