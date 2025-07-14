@extends('layouts.app')

@section('title', 'Riwayat Pemesanan - Tiket.ku')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Riwayat Pemesanan Anda</h1>
        <p class="text-gray-500">Semua transaksi tiket Anda yang telah selesai.</p>
    </div>

    <div class="space-y-6">
        {{-- Gunakan @forelse untuk loop data dan menangani jika data kosong --}}
        @forelse ($pemesanan as $pesanan)
            {{-- Setiap kartu riwayat bisa diklik untuk melihat detail --}}
            <a href="{{ route('pembayaran.show', $pesanan->id) }}" class="block bg-white p-6 rounded-xl shadow-md border border-gray-200 transition hover:shadow-lg hover:border-purple-300">
                <div class="flex justify-between items-start">
                    {{-- Detail Rute dan Maskapai --}}
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-lg text-gray-800">{{ $pesanan->penerbangan->bandaraAsal->kota }}</span>
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                            <span class="font-bold text-lg text-gray-800">{{ $pesanan->penerbangan->bandaraTujuan->kota }}</span>
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ $pesanan->penerbangan->maskapai->nama_maskapai }} • {{ \Carbon\Carbon::parse($pesanan->penerbangan->tanggal_berangkat)->isoFormat('dddd, D MMM YYYY') }}
                        </p>
                    </div>

                    {{-- Status dan Harga --}}
                    <div class="text-right">
                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                            {{ $pesanan->status_pembayaran == 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $pesanan->status_pembayaran }}
                        </span>
                        <p class="font-bold text-lg text-purple-700 mt-2">IDR {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                    </div>
                </div>

                {{-- Informasi Tambahan --}}
                <div class="mt-4 pt-4 border-t border-gray-200 text-sm text-gray-500">
                    <span>Kode Booking: <span class="font-medium text-gray-700">{{ $pesanan->kode_booking }}</span></span>
                </div>
            </a>
        @empty
            {{-- Tampilan jika tidak ada riwayat sama sekali --}}
            <div class="bg-white p-8 rounded-xl shadow-md text-center text-gray-500">
                <p class="font-semibold text-lg">Anda belum memiliki riwayat pemesanan.</p>
                <p class="mt-2">Ayo mulai cari penerbangan pertama Anda!</p>
                <a href="{{ route('jadwal') }}" class="mt-4 inline-block bg-purple-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-purple-700 transition-colors">
                    Cari Tiket
                </a>
            </div>
        @endforelse

        {{-- Link untuk Paginasi --}}
        <div class="mt-8">
            {{ $pemesanan->links() }}
        </div>
    </div>
</div>
@endsection