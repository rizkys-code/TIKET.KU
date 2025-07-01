@extends('layouts.app')

@section('title', 'Hasil Pencarian Tiket Pesawat')

@section('content')

    @php
        $flights = [
            [
                'airline' => 'Singapore Airlines',
                'logo' => 'https://i.imgur.com/kS5yYdO.png',
                'departure_time' => '07:00',
                'departure_code' => 'CGK',
                'arrival_time' => '14:00',
                'arrival_code' => 'SIN',
                'price' => 1500000,
            ],
            [
                'airline' => 'Lion Air',
                'logo' => 'https://i.imgur.com/v1h3kHl.png',
                'departure_time' => '07:00',
                'departure_code' => 'CGK',
                'arrival_time' => '14:00',
                'arrival_code' => 'SIN',
                'price' => 1500000,
            ],
            [
                'airline' => 'Citilink',
                'logo' => 'https://i.imgur.com/Kz4YAYg.png',
                'departure_time' => '07:00',
                'departure_code' => 'CGK',
                'arrival_time' => '14:00',
                'arrival_code' => 'SIN',
                'price' => 1500000,
            ],
        ];
    @endphp

    <div class="max-w-6xl mx-auto" x-data="flightSearch()">
        <!-- Header -->
        <header class="flex justify-between items-center mb-6">
            <span class="mb-3 text-4xl font-bold text-tiket-purple">Tiket<span class="text-[#FFAF00]">.</span><span
                    class="text-black">Ku</span></span>
            <div class="relative w-1/3">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
                <input type="text" placeholder="Cari Tiket"
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-300 shadow-sm">
            </div>
        </header>

        <!-- Filter Bar (REVISED) -->
        <div class="bg-white p-2 rounded-xl shadow-lg flex items-center text-sm text-gray-700 mb-6">
            <!-- Fields Container -->
            <div class="flex-grow flex items-center divide-x divide-gray-200">

                <!-- 1. Search Icon -->
                <div class="flex items-center px-4">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

                <!-- 2. From & To with Switch (Struktur 3 Kolom yang Stabil) -->
                <div class="w-4/12 flex items-center px-4 py-1">
                    <!-- Kolom Kiri (From) -->
                    <div class="flex-1 text-right">
                        <span x-text="from" class="font-semibold whitespace-nowrap"></span>
                    </div>
                    <!-- Kolom Tengah (Icon) - Lebar Tetap -->
                    <div class="flex-shrink-0 mx-2">
                        <button @click="switchCities()"
                            class="p-1 rounded-full text-gray-500 hover:bg-gray-100 focus:outline-none">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </button>
                    </div>
                    <!-- Kolom Kanan (To) -->
                    <div class="flex-1 text-left">
                        <span x-text="to" class="font-semibold whitespace-nowrap"></span>
                    </div>
                </div>

                <!-- 3. Date Picker (Lebar 5/12 - PALING LEBAR) -->
                <div class="w-5/12 flex items-center justify-start px-4 py-1">
                    <div class="relative w-full">
                        <input type="text" id="datepicker"
                            class="w-full cursor-pointer bg-transparent border-none p-0 focus:ring-0"
                            :value="dateText">
                    </div>
                </div>

                <!-- 4. Passenger Picker (Lebar 3/12) -->
                <div class="w-3/12 flex items-center justify-start px-4 py-1">
                    <div class="relative" @click.away="passengerPickerOpen = false">
                        <button @click="passengerPickerOpen = !passengerPickerOpen"
                            class="flex items-center space-x-1 whitespace-nowrap">
                            <span
                                x-text="`${passengers.adult + passengers.child + passengers.infant} Penumpang, ${passengerClass}`"></span>
                        </button>
                        <div x-show="passengerPickerOpen" x-transition
                            class="absolute top-full mt-2 w-72 bg-white rounded-xl shadow-lg p-4 z-10">
                            <!-- Passenger Counts -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">Dewasa</p>
                                        <p class="text-xs text-gray-500">(12 tahun ke atas)</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <button @click="passengers.adult > 1 ? passengers.adult-- : null"
                                            class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                        <span x-text="passengers.adult" class="w-4 text-center"></span>
                                        <button @click="passengers.adult++"
                                            class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">Anak</p>
                                        <p class="text-xs text-gray-500">(2 - 11 tahun)</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <button @click="passengers.child > 0 ? passengers.child-- : null"
                                            class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                        <span x-text="passengers.child" class="w-4 text-center"></span>
                                        <button @click="passengers.child++"
                                            class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Class Selector -->
                            <div class="mt-4 border-t pt-4">
                                <select x-model="passengerClass"
                                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option>Ekonomi</option>
                                    <option>Bisnis</option>
                                    <option>First Class</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Button -->
            <div class="pl-4 pr-3">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-10 rounded-lg transition-colors">
                    Cari
                </button>
            </div>
        </div>
        <!-- End of Filter Bar -->

        <!-- Tombol Filter Maskapai -->
        <div class="flex justify-center mb-8">
            <button
                class="bg-white border border-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-full shadow-md flex items-center space-x-2 hover:bg-gray-50">
                <svg class="w-5 h-5 -rotate-45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
                <span>Maskapai</span>
            </button>
        </div>

        <!-- Daftar Hasil Penerbangan -->
        <div class="space-y-4">
            @foreach ($flights as $flight)
                <div
                    class="bg-white p-5 rounded-xl shadow-md flex items-center justify-between transition hover:shadow-lg hover:-translate-y-1">
                    <!-- Bagian Kiri: Logo dan Nama Maskapai -->
                    <div class="flex items-center space-x-6 w-1/3">
                        <img src="{{ $flight['logo'] }}" alt="{{ $flight['airline'] }} Logo" class="h-8 object-contain">
                        <span class="font-semibold text-gray-900 text-base">{{ $flight['airline'] }}</span>
                    </div>

                    <!-- Bagian Tengah: Waktu dan Rute -->
                    <div class="flex items-center justify-center space-x-8 flex-grow">
                        <div class="text-center">
                            <p class="text-xl font-bold text-gray-900">{{ $flight['departure_time'] }}</p>
                            <p class="text-sm text-gray-500">{{ $flight['departure_code'] }}</p>
                        </div>
                        <div class="text-center text-gray-400">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-gray-900">{{ $flight['arrival_time'] }}</p>
                            <p class="text-sm text-gray-500">{{ $flight['arrival_code'] }}</p>
                        </div>
                    </div>

                    <!-- Bagian Kanan: Harga -->
                    <div class="text-right w-1/3">
                        <p class="text-xl font-bold text-gray-900">IDR {{ number_format($flight['price'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function flightSearch() {
            return {
                from: 'Jakarta, CGK',
                to: 'Singapore, SIN',
                dateText: 'Sabtu, 9 Agt 25 - Rabu, 13 Agt 25 (Pulang Pergi)',
                passengerPickerOpen: false,
                passengers: {
                    adult: 1,
                    child: 0,
                    infant: 0
                },
                passengerClass: 'Ekonomi',

                // Fungsi untuk menukar kota
                switchCities() {
                    [this.from, this.to] = [this.to, this.from];
                },

                // Inisialisasi komponen saat Alpine.js dimuat
                init() {
                    const picker = new Litepicker({
                        element: document.getElementById('datepicker'),
                        singleMode: false,
                        allowRepick: true,
                        numberOfMonths: 2,
                        numberOfColumns: 2,
                        format: 'ddd, D MMM YY',
                        lang: 'id-ID', // Set bahasa ke Indonesia
                        buttonText: {
                            previousMonth: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>`,
                            nextMonth: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>`,
                            apply: 'Terapkan',
                            cancel: 'Batal',
                        },
                        setup: (picker) => {
                            picker.on('selected', (date1, date2) => {
                                if (!date1 || !date2) return;
                                // Update text saat tanggal dipilih
                                const d1 = date1.dateInstance;
                                const d2 = date2.dateInstance;
                                const options = {
                                    weekday: 'short',
                                    day: 'numeric',
                                    month: 'short',
                                    year: '2-digit'
                                };

                                const formattedDate1 = new Intl.DateTimeFormat('id-ID', options).format(
                                    d1).replace(/\./g, '');
                                const formattedDate2 = new Intl.DateTimeFormat('id-ID', options).format(
                                    d2).replace(/\./g, '');

                                this.dateText = `${formattedDate1} - ${formattedDate2} (Pulang Pergi)`;
                            });
                        },
                    });
                }
            }
        }
    </script>
@endpush
