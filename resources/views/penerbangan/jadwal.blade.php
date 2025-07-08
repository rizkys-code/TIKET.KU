@extends('layouts.app')

@section('title', 'Hasil Pencarian Tiket Pesawat')

@section('content')

    <div class="max-w-6xl mx-auto" x-data="flightSearch()">
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

        <!-- MODIFIED: Wrapped the search bar in a form tag -->
        {{-- <form method="GET" action="{{ route('flight.search') }}" id="flightSearchForm"> --}}
        <form method="GET" action="{{ route('jadwal') }}" id="flightSearchForm">
            {{-- Search Bar --}}
            <div class="bg-white p-2 rounded-xl shadow-lg flex items-center text-sm text-gray-700 mb-6">
                <div class="flex-grow flex items-center divide-x divide-gray-200">
                    {{-- Icon --}}
                    <div class="flex items-center px-4">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>

                    {{-- From & To --}}
                    <div class="w-4/12 flex items-center px-4 py-1">
                        <!-- MODIFIED: Added hidden inputs to send data to server -->
                        <input type="hidden" name="from" :value="from">
                        <input type="hidden" name="to" :value="to">

                        <div class="flex-1 text-right">
                            <span x-text="from" class="font-semibold whitespace-nowrap"></span>
                        </div>
                        <div class="flex-shrink-0 mx-2">
                            <button type="button" @click="switchCities()"
                                class="p-1 rounded-full text-gray-500 hover:bg-gray-100 focus:outline-none">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 text-left">
                            <span x-text="to" class="font-semibold whitespace-nowrap"></span>
                        </div>
                    </div>

                    {{-- Date Picker --}}
                    <div class="w-5/12 flex items-center justify-start px-4 py-1">
                        <div class="relative w-full">
                            <!-- MODIFIED: Added name attribute -->
                            <input type="text" id="datepicker" name="date"
                                class="w-full cursor-pointer bg-transparent border-none p-0 focus:ring-0"
                                :value="dateText">
                        </div>
                    </div>

                    {{-- Passenger & Class Picker --}}
                    <div class="w-3/12 flex items-center justify-start px-4 py-1">
                        <!-- MODIFIED: Added hidden inputs for passenger counts -->
                        <input type="hidden" name="passengers[adult]" :value="passengers.adult">
                        <input type="hidden" name="passengers[child]" :value="passengers.child">
                        <input type="hidden" name="passengers[infant]" :value="passengers.infant">

                        <div class="relative" @click.away="passengerPickerOpen = false">
                            <button type="button" @click="passengerPickerOpen = !passengerPickerOpen"
                                class="flex items-center space-x-1 whitespace-nowrap">
                                <span
                                    x-text="`${passengers.adult + passengers.child + passengers.infant} Penumpang, ${passengerClass}`"></span>
                            </button>
                            <div x-show="passengerPickerOpen" x-transition
                                class="absolute top-full mt-2 w-72 bg-white rounded-xl shadow-lg p-4 z-10"
                                style="display: none;">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">Dewasa</p>
                                            <p class="text-xs text-gray-500">(12 tahun ke atas)</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="passengers.adult > 1 ? passengers.adult-- : null"
                                                class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                            <span x-text="passengers.adult" class="w-4 text-center"></span>
                                            <button type="button" @click="passengers.adult++"
                                                class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">Anak</p>
                                            <p class="text-xs text-gray-500">(2 - 11 tahun)</p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="passengers.child > 0 ? passengers.child-- : null"
                                                class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                            <span x-text="passengers.child" class="w-4 text-center"></span>
                                            <button type="button" @click="passengers.child++"
                                                class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 border-t pt-4">
                                    <!-- MODIFIED: Added name attribute -->
                                    <select x-model="passengerClass" name="passengerClass"
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

                {{-- Search Button --}}
                <div class="pl-4 pr-3">
                    <!-- MODIFIED: Changed to type="submit" -->
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-10 rounded-lg transition-colors">
                        Cari
                    </button>
                </div>
            </div>
            <!-- MODIFIED: Hidden input for airline filter -->
            <input type="hidden" name="airline_filter" value="{{ request('airline_filter') }}">
        </form>

        {{-- Airline Filter Dropdown --}}
        <div class="flex justify-center mb-8">
            <div @click.away="airlineDropdownOpen = false" class="relative">
                <button @click="airlineDropdownOpen = !airlineDropdownOpen"
                    class="bg-white border border-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-full shadow-md flex items-center space-x-2 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 -rotate-45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                    <span>Maskapai</span>
                    <svg class="w-5 h-5 ml-1 text-gray-500 transition-transform duration-200"
                        :class="{ 'rotate-180': airlineDropdownOpen }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="airlineDropdownOpen" x-transition
                    class="absolute z-10 mt-2 w-60 left-0 right-0 mx-auto bg-white rounded-xl shadow-lg"
                    style="display: none;">
                    {{-- <div class="p-2 space-y-1">
                        <a href="{{ request()->fullUrlWithQuery(['airline_filter' => '']) }}"
                            class="flex items-center ...">
                            <span class="font-medium">Semua Maskapai</span>
                        </a>
                        @php
                            $airlines = $flights_for_filter->pluck('maskapai')->filter()->unique('id');
                        @endphp
                        @foreach ($airlines as $airline)
                            <a href="{{ request()->fullUrlWithQuery(['airline_filter' => $airline->id]) }}"
                                class="flex items-center ...">
                                <span class="font-medium">{{ $airline->nama_maskapai }}</span>
                            </a>
                        @endforeach
                    </div> --}}

                    <div class="p-2 space-y-1">
                        {{-- Link untuk menghapus filter --}}
                        <a href="{{ request()->fullUrlWithQuery(['airline_filter' => '']) }}"
                            class="flex items-center ...">
                            <span class="font-medium">Semua Maskapai</span>
                        </a>

                        {{-- Loop ini sekarang menggunakan variabel yang tepat --}}
                        @php
                            $airlines = $flights_for_filter->pluck('maskapai')->filter()->unique('id');
                        @endphp
                        @foreach ($airlines as $airline)
                            <a href="{{ request()->fullUrlWithQuery(['airline_filter' => $airline->id]) }}"
                                class="flex items-center ...">
                                {{-- ... --}}
                                <span class="font-medium">{{ $airline->nama_maskapai }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            {{-- MODIFIED: Check if there are any flights --}}
            @forelse ($flights as $flight)
                <div
                    class="bg-white p-5 rounded-xl shadow-md flex items-center justify-between transition hover:shadow-lg hover:-translate-y-1">
                    {{-- Airline Info --}}
                    <div class="flex items-center space-x-6 w-1/3">
                        @if ($flight->maskapai)
                            <img src="{{ asset('storage/logo-maskapai/' . Str::slug($flight->maskapai->nama_maskapai) . '.png') }}"
                                alt="{{ $flight->maskapai->nama_maskapai }} Logo" class="h-8 object-contain">
                            <span class="font-semibold text-gray-900 text-base">
                                {{ $flight->maskapai->nama_maskapai }}
                            </span>
                        @else
                            <div class="h-8 w-8 bg-gray-200 rounded-full"></div>
                            <span class="font-semibold text-gray-500">Maskapai tidak diketahui</span>
                        @endif
                    </div>

                    {{-- Flight Time & Route --}}
                    <div class="flex items-center justify-center space-x-8 flex-grow">
                        <div class="text-center">
                            <p class="text-xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($flight->waktu_berangkat)->format('H:i') }}</p>
                            <p class="text-sm text-gray-500">{{ $flight->bandaraAsal?->kode_bandara ?? 'N/A' }}</p>
                        </div>
                        <div class="text-center text-gray-400">
                            <p class="text-xs">Langsung</p>
                            <div class="w-24 h-px bg-gray-300 my-1"></div>
                            <p class="text-xs">
                                {{ \Carbon\Carbon::parse($flight->waktu_berangkat)->diff(\Carbon\Carbon::parse($flight->waktu_tiba))->format('%hh %im') }}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-gray-900">
                                {{ \Carbon\Carbon::parse($flight->waktu_tiba)->format('H:i') }}</p>
                            <p class="text-sm text-gray-500">{{ $flight->bandaraTujuan?->kode_bandara ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Price --}}
                    <div class="text-right w-1/3">
                        @php
                            $requestedClass = $search['passengerClass'] ?? 'Ekonomi';
                            $harga = $flight->kelas->firstWhere('jenis_kelas', $requestedClass)?->harga ?? 0;
                        @endphp
                        <p class="text-xl font-bold text-red-600">IDR {{ number_format($harga, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">/pax</p>
                    </div>
                </div>
            @empty
                {{-- MODIFIED: Message when no flights are found --}}
                <div class="bg-white p-8 rounded-xl shadow-md text-center text-gray-500">
                    <p class="font-semibold text-lg">Penerbangan tidak ditemukan</p>
                    <p class="mt-2">Coba ubah kriteria pencarian atau tanggal Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script tetap sama, tidak perlu diubah --}}
    <script>
        function flightSearch() {
            return {
                // Search State
                from: @json($search['from'] ?? 'Jakarta'), // Fallback values
                to: @json($search['to'] ?? 'Surabaya'),
                dateText: @json($search['dateText'] ?? 'Pilih Tanggal'),
                passengerClass: @json($search['passengerClass'] ?? 'Ekonomi'),
                passengers: @json($search['passengers'] ?? ['adult' => 1, 'child' => 0, 'infant' => 0]),

                // UI State
                passengerPickerOpen: false,
                airlineDropdownOpen: false,

                switchCities() {
                    [this.from, this.to] = [this.to, this.from];
                },

                init() {
                    // Litepicker Initialization
                    const picker = new Litepicker({
                        element: document.getElementById('datepicker'),
                        singleMode: false,
                        allowRepick: true,
                        numberOfMonths: 2,
                        numberOfColumns: 2,
                        format: 'ddd, D MMM YY',
                        lang: 'id-ID',
                        buttonText: {
                            previousMonth: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>`,
                            nextMonth: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>`,
                            apply: 'Terapkan',
                            cancel: 'Batal',
                        },
                        setup: (picker) => {
                            picker.on('selected', (date1, date2) => {
                                if (!date1) {
                                    this.dateText = 'Pilih Tanggal';
                                    return;
                                };

                                const options = {
                                    weekday: 'short',
                                    day: 'numeric',
                                    month: 'short',
                                    year: '2-digit'
                                };
                                const formatter = new Intl.DateTimeFormat('id-ID', options);

                                const formattedDate1 = formatter.format(date1.dateInstance).replace(
                                    /\./g, '');

                                if (date2) {
                                    const formattedDate2 = formatter.format(date2.dateInstance).replace(
                                        /\./g, '');
                                    this.dateText = `${formattedDate1} - ${formattedDate2}`;
                                } else {
                                    this.dateText = formattedDate1;
                                }
                            });
                        },
                    });
                }
            }
        }
    </script>
@endpush
