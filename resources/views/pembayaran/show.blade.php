@extends('layouts.app')

@section('title', 'Detail Pemesanan - Tiket.ku')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Notifikasi Sukses (jika ada) --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
        {{-- ========================================================== --}}
        {{-- === BAGIAN HEADER YANG DINAMIS                         === --}}
        {{-- ========================================================== --}}
        <div class="flex justify-between items-center mb-4 pb-4 border-b">
            <div>
                {{-- Judul berubah sesuai status pembayaran --}}
                @if($pemesanan->status_pembayaran == 'Lunas')
                    <h1 class="text-2xl font-bold text-gray-800">Detail Pemesanan</h1>
                    <p class="text-gray-500">Kode Booking: <span class="font-semibold">{{ $pemesanan->kode_booking }}</span></p>
                @else
                    <h1 class="text-2xl font-bold text-gray-800">Menunggu Pembayaran</h1>
                    <p class="text-gray-500">Selesaikan pembayaran Anda sebelum batas waktu.</p>
                @endif
            </div>
            
            {{-- Tombol Unduh PDF hanya muncul jika sudah Lunas --}}
            @if($pemesanan->status_pembayaran == 'Lunas')
            <a href="{{ route('eticket.download', $pemesanan->id) }}"
               class="bg-purple-600 text-white font-bold py-2 px-5 rounded-lg hover:bg-purple-700 transition-colors shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.75a.75.75 0 00-1.5 0v8.614L6.295 8.235a.75.75 0 10-1.09 1.03l4.25 4.5a.75.75 0 001.09 0l4.25-4.5a.75.75 0 10-1.09-1.03l-2.955 3.129V2.75z" /><path d="M3.5 12.75a.75.75 0 00-1.5 0v2.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25v-2.5a.75.75 0 00-1.5 0v2.5c0 .69-.56 1.25-1.25 1.25H4.75c-.69 0-1.25-.56-1.25-1.25v-2.5z" /></svg>
                <span>Unduh E-Tiket</span>
            </a>
            @else
                <span class="text-lg font-semibold text-red-600">IDR {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</span>
            @endif
        </div>
        {{-- ========================================================== --}}


        {{-- Detail Penerbangan (Timeline) - tidak berubah --}}
        <div class="grid grid-cols-[auto_auto_1fr] gap-x-4 mb-6">
            <div class="text-right">
                <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->waktu_berangkat)->format('H:i') }}</p>
            </div>
            <div class="relative flex-col items-center flex">
                <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                <div class="w-0.5 h-full bg-gray-300 my-1"></div>
                <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
            </div>
            <div class="space-y-4 pb-4">
                <p class="font-semibold text-gray-700">{{ $pemesanan->penerbangan->bandaraAsal->nama_bandara }} ({{ $pemesanan->penerbangan->bandaraAsal->kode_bandara }})</p>
                <div class="border rounded-lg p-4">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('storage/logo-maskapai/' . Str::slug($pemesanan->penerbangan->maskapai->nama_maskapai) . '.png') }}" alt="Logo" class="h-6">
                        <div>
                            <p class="font-bold text-gray-800">{{ $pemesanan->penerbangan->maskapai->nama_maskapai }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        {{-- Opsi metode pembayaran hanya muncul jika belum lunas --}}
                        @if($pemesanan->status_pembayaran != 'Lunas')
                        <div>
                            <label for="payment_method" class="text-sm font-medium text-gray-600">Metode Pembayaran</label>
                            <select id="payment_method" name="payment_method" class="mt-1 w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                                <option>Transfer Bank</option>
                                <option>Kartu Kredit</option>
                                <option>GoPay</option>
                                <option>OVO</option>
                            </select>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-medium text-gray-600">Status Pembayaran</p>
                            <p class="mt-1 text-base font-semibold {{ $pemesanan->status_pembayaran == 'Belum Dibayar' ? 'text-red-600' : 'text-green-600' }}">
                                {{ $pemesanan->status_pembayaran }}
                            </p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-600">Total Bayar</p>
                            <p class="font-bold text-lg text-purple-700">IDR {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-right">
                <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($pemesanan->penerbangan->waktu_tiba)->format('H:i') }}</p>
            </div>
            <div></div>
            <div>
                <p class="font-semibold text-gray-700">{{ $pemesanan->penerbangan->bandaraTujuan->nama_bandara }} ({{ $pemesanan->penerbangan->bandaraTujuan->kode_bandara }})</p>
            </div>
        </div>

        {{-- ========================================================== --}}
        {{-- === BAGIAN BARU: TAMPILKAN DETAIL PENUMPANG            === --}}
        {{-- ========================================================== --}}
        <div class="border-t pt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Penumpang</h2>
            <div class="space-y-3">
                @foreach($pemesanan->penumpangs as $index => $penumpang)
                    <div class="bg-gray-50 p-3 rounded-lg flex justify-between items-center">
                        <p class="text-gray-700"><span class="font-semibold">{{ $index + 1 }}. {{ $penumpang->nama }}</span></p>
                        <p class="text-sm text-gray-500">ID: {{ $penumpang->nomor_identitas }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        {{-- ========================================================== --}}

    </div>

    {{-- ========================================================== --}}
    {{-- === TOMBOL AKSI YANG DINAMIS                           === --}}
    {{-- ========================================================== --}}
    {{-- Tombol "Bayar Sekarang" hanya muncul jika belum lunas --}}
    @if($pemesanan->status_pembayaran != 'Lunas')
        <div class="mt-8 text-right">
            <form action="{{ route('pembayaran.process', $pemesanan->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-purple-600 text-white font-bold py-3 px-10 rounded-lg hover:bg-purple-700 transition-colors shadow-md">
                    Bayar Sekarang
                </button>
            </form>
        </div>
    @endif
</div>
@endsection