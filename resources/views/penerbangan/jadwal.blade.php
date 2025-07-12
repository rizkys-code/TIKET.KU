{{-- resources/views/penerbangan/jadwal.blade.php --}}
@extends('layouts.app')

@section('title', 'Hasil Pencarian Tiket Pesawat')

@section('content')
    <div class="max-w-6xl mx-auto" x-data="flightSearch()">
        <form method="GET" action="{{ route('jadwal') }}" id="flightSearchForm">
            <div class="bg-white p-2 rounded-xl shadow-lg flex items-center text-sm text-gray-700 mb-6">
                <div class="flex-grow flex items-center divide-x divide-gray-200">
                    <div class="px-4">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    {{-- Asal & Tujuan --}}
                    <div class="w-4/12 flex items-center px-4 py-1">
                        <input type="hidden" name="from" :value="from">
                        <input type="hidden" name="to" :value="to">
                        <div class="flex-1 text-right"><span x-text="from" class="font-semibold whitespace-nowrap"></span></div>
                        <div class="flex-shrink-0 mx-2">
                            <button type="button" @click="switchCities()" class="p-1 rounded-full text-gray-500 hover:bg-gray-100 focus:outline-none"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" /></svg></button>
                        </div>
                        <div class="flex-1 text-left"><span x-text="to" class="font-semibold whitespace-nowrap"></span></div>
                    </div>
                    {{-- Tanggal --}}
                    <div class="w-5/12 flex items-center justify-start px-4 py-1">
                        <input type="text" id="datepicker" name="date" class="w-full cursor-pointer bg-transparent border-none p-0 focus:ring-0" readonly :value="dateText" placeholder="Pilih Tanggal">
                    </div>
                    {{-- Penumpang & Kelas --}}
                    <div class="w-3/12 flex items-center justify-start px-4 py-1">
                        <input type="hidden" name="passengers[adult]" :value="passengers.adult">
                        <input type="hidden" name="passengers[child]" :value="passengers.child">
                        <input type="hidden" name="passengers[infant]" :value="passengers.infant">
                        <input type="hidden" name="passengerClass" :value="passengerClass">

                        <div class="relative" @click.away="passengerPickerOpen = false">
                            <button type="button" @click="passengerPickerOpen = !passengerPickerOpen" class="flex items-center space-x-1 whitespace-nowrap">
                                <span x-text="`${passengers.adult + passengers.child + passengers.infant} Penumpang, ${passengerClass}`"></span>
                            </button>
                            <div x-show="passengerPickerOpen" x-transition class="absolute top-full mt-2 w-72 bg-white rounded-xl shadow-lg p-4 z-10" style="display: none;">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <div><p class="font-semibold">Dewasa</p><p class="text-xs text-gray-500">(12+ thn)</p></div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="passengers.adult > 1 ? passengers.adult-- : null" class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                            <span x-text="passengers.adult" class="w-4 text-center"></span>
                                            <button type="button" @click="passengers.adult++" class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div><p class="font-semibold">Anak</p><p class="text-xs text-gray-500">(2 - 11 thn)</p></div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="passengers.child > 0 ? passengers.child-- : null" class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                            <span x-text="passengers.child" class="w-4 text-center"></span>
                                            <button type="button" @click="passengers.child++" class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div><p class="font-semibold">Bayi</p><p class="text-xs text-gray-500">(< 2 thn)</p></div>
                                        <div class="flex items-center space-x-3">
                                            <button type="button" @click="passengers.infant > 0 ? passengers.infant-- : null" class="w-7 h-7 border rounded-full text-lg font-bold text-gray-500">-</button>
                                            <span x-text="passengers.infant" class="w-4 text-center"></span>
                                            <button type="button" @click="passengers.infant++" class="w-7 h-7 border rounded-full text-lg font-bold text-blue-500">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 border-t pt-4">
                                    <select x-model="passengerClass" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option>Ekonomi</option><option>Bisnis</option><option>First Class</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pl-4 pr-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-10 rounded-lg transition-colors">Ubah Cari</button>
                </div>
            </div>
            <input type="hidden" name="airline_filter" id="airline_filter_input" value="{{ request('airline_filter') }}">
        </form>

        <div class="flex justify-center mb-8">
            <div @click.away="airlineDropdownOpen = false" class="relative">
                <button @click="airlineDropdownOpen = !airlineDropdownOpen" class="bg-white border border-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-full shadow-md flex items-center space-x-2 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 -rotate-45" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                    <span>Maskapai</span>
                    <svg class="w-5 h-5 ml-1 text-gray-500 transition-transform duration-200" :class="{ 'rotate-180': airlineDropdownOpen }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
                <div x-show="airlineDropdownOpen" x-transition class="absolute z-10 mt-2 w-60 left-0 right-0 mx-auto bg-white rounded-xl shadow-lg" style="display: none;">
                    <div class="p-2 space-y-1">
                        <button type="button" @click="filterAirline('')" class="w-full text-left flex items-center p-2 rounded-lg hover:bg-gray-100"><span class="font-medium">Semua Maskapai</span></button>
                        @foreach ($flights_for_filter->pluck('maskapai')->filter()->unique('id') as $airline)
                            <button type="button" @click="filterAirline('{{ $airline->id }}')" class="w-full text-left flex items-center p-2 rounded-lg hover:bg-gray-100">
                                <span class="font-medium">{{ $airline->nama_maskapai }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($flights as $flight)
                <a href="{{ route('pemesanan.show', ['penerbangan' => $flight->id]) . '?' . http_build_query($search) }}" class="block bg-white p-5 rounded-xl shadow-md transition hover:shadow-lg hover:-translate-y-1 cursor-pointer">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-6 w-1/3">
                            @if ($flight->maskapai)
                                <img src="{{ asset('storage/logo-maskapai/' . Str::slug($flight->maskapai->nama_maskapai) . '.png') }}" alt="{{ $flight->maskapai->nama_maskapai }} Logo" class="h-8 object-contain">
                                <span class="font-semibold text-gray-900 text-base">{{ $flight->maskapai->nama_maskapai }}</span>
                            @else
                                <div class="h-8 w-8 bg-gray-200 rounded-full"></div><span class="font-semibold text-gray-500">Maskapai tidak diketahui</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-center space-x-8 flex-grow">
                            <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($flight->waktu_berangkat)->format('H:i') }}</p><p class="text-sm text-gray-500">{{ $flight->bandaraAsal?->kode_bandara ?? 'N/A' }}</p></div>
                            <div class="text-center text-gray-400"><p class="text-xs">Langsung</p><div class="w-24 h-px bg-gray-300 my-1"></div><p class="text-xs">{{ \Carbon\Carbon::parse($flight->waktu_berangkat)->diff(\Carbon\Carbon::parse($flight->waktu_tiba))->format('%h jam %i mnt') }}</p></div>
                            <div class="text-center"><p class="text-xl font-bold text-gray-900">{{ \Carbon\Carbon::parse($flight->waktu_tiba)->format('H:i') }}</p><p class="text-sm text-gray-500">{{ $flight->bandaraTujuan?->kode_bandara ?? 'N/A' }}</p></div>
                        </div>
                        <div class="text-right w-1/3">
                            @php
                                $requestedClass = $search['passengerClass'] ?? 'Ekonomi';
                                $harga = $flight->kelas->firstWhere('jenis_kelas', $requestedClass)?->harga ?? 0;
                            @endphp
                            <p class="text-xl font-bold text-red-600">IDR {{ number_format($harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">/pax</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="bg-white p-8 rounded-xl shadow-md text-center text-gray-500"><p class="font-semibold text-lg">Penerbangan tidak ditemukan</p><p class="mt-2">Coba ubah kriteria pencarian atau tanggal Anda.</p></div>
            @endforelse
            <div class="mt-8">
                {{ $flights->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function flightSearch() {
        return {
            from: @json($search['from'] ?? 'Jakarta'),
            to: @json($search['to'] ?? 'Surabaya'),
            dateText: @json($search['date'] ?? ''),
            passengerClass: @json($search['passengerClass'] ?? 'Ekonomi'),
            passengers: {
                adult: parseInt(@json($search['passengers']['adult'] ?? 1)),
                child: parseInt(@json($search['passengers']['child'] ?? 0)),
                infant: parseInt(@json($search['passengers']['infant'] ?? 0)),
            },
            
            init() {
                // ================================================================
                // KODE DEBUGGING JAVASCRIPT
                // ================================================================
                console.log('AlpineJS Mulai Dijalankan. Nilai awal dateText:', this.dateText);
                // ================================================================

                new Litepicker({
                    element: document.getElementById('datepicker'),
                    singleMode: true,
                    minDate: new Date(),
                    format: 'DD MMMM YYYY',
                    lang: 'id-ID',
                    setup: (picker) => {
                        // Inisialisasi tanggal awal jika ada
                        if (this.dateText) {
                             console.log('Litepicker akan set tanggal awal ke:', this.dateText);
                             picker.setDate(this.dateText);
                        }

                        picker.on('selected', () => {
                            console.log('Tanggal DIPILIH. Nilai baru:', picker.getVal());
                            this.dateText = picker.getVal();
                        });
                    }
                });
            }
        }
    }
</script>
@endpush