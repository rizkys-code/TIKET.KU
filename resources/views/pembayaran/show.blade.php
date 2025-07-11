@extends('layouts.app')

@section('title', 'Pembayaran - Tiket.ku')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Notifikasi atau Alert --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        <div class="flex justify-between items-center mb-4 pb-4 border-b">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Menunggu Pembayaran</h1>
                <p class="text-gray-500">Selesaikan pembayaran Anda sebelum batas waktu.</p>
            </div>
            <span class="text-lg font-semibold text-red-600">IDR {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
        </div>

        {{-- Detail Penerbangan (Timeline) --}}
        <div class="grid grid-cols-[auto_auto_1fr] gap-x-4">
            <!-- Kolom 1: Waktu Berangkat -->
            <div class="text-right">
                <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->waktu_berangkat)->format('H:i') }}</p>
            </div>
            <!-- Kolom 2: Garis Timeline -->
            <div class="relative flex-col items-center flex">
                <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                <div class="w-0.5 h-full bg-gray-300 my-1"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
            </div>
            <!-- Kolom 3: Detail Penerbangan -->
            <div class="space-y-4 pb-4">
                <p class="font-semibold text-gray-700">{{ $pemesanan->penerbangan->bandaraAsal->nama_bandara }} ({{ $pemesanan->penerbangan->bandaraAsal->kode_bandara }})</p>

                {{-- Detail Maskapai & Pembayaran (Nested Card) --}}
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('storage/logo-maskapai/' . Str::slug($pemesanan->penerbangan->maskapai->nama_maskapai) . '.png') }}" alt="Logo" class="h-6">
                        <div>
                            <p class="font-bold text-gray-800">{{ $pemesanan->penerbangan->maskapai->nama_maskapai }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label for="payment_method" class="text-sm font-medium text-gray-600">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="mt-1 w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                                <option>Transfer Bank</option>
                                <option>Kartu Kredit</option>
                                <option>GoPay</option>
                                <option>OVO</option>
                            </select>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Pembayaran</p>
                            <p class="mt-1 text-base font-semibold {{ $pemesanan->status_pembayaran == 'Belum Dibayar' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $pemesanan->status_pembayaran }}
                            </p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-600">Total Bayar</p>
                            <p class="font-bold text-lg text-purple-700">Rp{{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Waktu dan Bandara Tiba -->
            <div class="text-right">
                <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->waktu_tiba)->format('H:i') }}</p>
            </div>
            <div></div>
            <div>
                <p class="font-semibold text-gray-700">{{ $pemesanan->penerbangan->bandaraTujuan->nama_bandara }} ({{ $pemesanan->penerbangan->bandaraTujuan->kode_bandara }})</p>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-8 text-right">
        <form action="{{ route('pembayaran.process', $pemesanan->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-purple-600 text-white font-bold py-3 px-10 rounded-lg hover:bg-purple-700 transition-colors shadow-md">
                Bayar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection