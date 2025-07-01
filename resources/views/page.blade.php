@extends('layouts.app')

@section('content')

{{-- Data Dummy: Biasanya data ini dikirim dari Controller --}}
@php
    $flights = [
        [
            'airline' => 'Singapore Airlines',
            'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/d/d0/Singapore_Airlines_Logo.svg/250px-Singapore_Airlines_Logo.svg.png', // Ganti dengan path logo lokal kamu
            'departure_time' => '07:00',
            'departure_code' => 'CGK',
            'arrival_time' => '14:00',
            'arrival_code' => 'SIN',
            'price' => 1500000,
        ],
        [
            'airline' => 'Lion Air',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/62/Lion-Air-Logo.svg/200px-Lion-Air-Logo.svg.png', // Ganti dengan path logo lokal kamu
            'departure_time' => '07:00',
            'departure_code' => 'CGK',
            'arrival_time' => '14:00',
            'arrival_code' => 'SIN',
            'price' => 1500000,
        ],
        [
            'airline' => 'Citilink',
            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3e/Citilink_logo.svg/220px-Citilink_logo.svg.png', // Ganti dengan path logo lokal kamu
            'departure_time' => '07:00',
            'departure_code' => 'CGK',
            'arrival_time' => '14:00',
            'arrival_code' => 'SIN',
            'price' => 1500000,
        ],
    ];
@endphp

<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <header class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-purple-600">Tiket.ku</h1>
        <div class="relative w-1/3">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" placeholder="Cari Tiket" class="w-full pl-10 pr-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500">
        </div>
    </header>

    <!-- Filter Bar -->
    <div class="bg-white p-3 rounded-lg shadow-md flex items-center justify-between text-sm text-gray-700 mb-6">
        <div class="flex items-center space-x-4">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span>Jakarta, CGK</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
            <span>Singapore, SIN</span>
        </div>
        <div class="flex items-center space-x-4">
            <span class="border-l border-gray-300 h-6 mx-2"></span>
            <span>Sabtu, 9 Agt 25 - Rabu, 13 Agt 25 (Pulang Pergi)</span>
            <span class="border-l border-gray-300 h-6 mx-2"></span>
            <span>1 Penumpang, Ekonomi</span>
        </div>
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-8 rounded-md">
            Cari
        </button>
    </div>

    <!-- Tombol Filter Maskapai -->
    <div class="flex justify-center mb-8">
        <button class="bg-white border border-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-full shadow-sm flex items-center space-x-2 hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
            </svg>
            <span>Maskapai</span>
        </button>
    </div>

    <!-- Daftar Hasil Penerbangan -->
    <div class="space-y-4">
        @foreach ($flights as $flight)
        <div class="bg-white p-5 rounded-xl shadow-sm flex items-center justify-between transition hover:shadow-lg">
            <!-- Bagian Kiri: Logo dan Nama Maskapai -->
            <div class="flex items-center space-x-4 w-1/3">
                <img src="{{ $flight['logo'] }}" alt="{{ $flight['airline'] }} Logo" class="h-8 object-contain">
                <span class="font-semibold text-gray-800">{{ $flight['airline'] }}</span>
            </div>

            <!-- Bagian Tengah: Waktu dan Rute -->
            <div class="flex items-center space-x-6 text-center">
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $flight['departure_time'] }}</p>
                    <p class="text-sm text-gray-500">{{ $flight['departure_code'] }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $flight['arrival_time'] }}</p>
                    <p class="text-sm text-gray-500">{{ $flight['arrival_code'] }}</p>
                </div>
            </div>

            <!-- Bagian Kanan: Harga -->
            <div class="text-right w-1/3">
                <p class="text-xl font-bold text-orange-500">IDR {{ number_format($flight['price'], 0, ',', '.') }}</p>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection