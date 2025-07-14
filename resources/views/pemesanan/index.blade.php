@extends('layouts.app')

@section('title', 'Detail Pemesanan - Tiket.ku')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                    <strong class="font-bold">Terjadi Kesalahan!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @csrf
            {{-- Input tersembunyi --}}
            <input type="hidden" name="penerbangan_id" value="{{ $penerbangan->id }}">
            <input type="hidden" name="passengerClass" value="{{ $passengerClass }}">
            @foreach ($search as $key => $value)
                @if (is_array($value))
                    @foreach ($value as $subKey => $subValue)
                        <input type="hidden" name="search[{{ $key }}][{{ $subKey }}]" value="{{ $subValue }}">
                    @endforeach
                @else
                    <input type="hidden" name="search[{{ $key }}]" value="{{ $value }}">
                @endif
            @endforeach

            {{-- ========================================================== --}}
            {{-- === PERUBAHAN DI SINI: Tombol Kembali Ditambahkan      === --}}
            {{-- ========================================================== --}}
            <div class="mb-6">
                {{-- Tombol untuk kembali ke halaman sebelumnya (hasil pencarian) --}}
                <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-800 transition-colors mb-4 text-sm">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z" clip-rule="evenodd" />
                    </svg>
                    <span>Kembali ke Hasil Pencarian</span>
                </a>
                
                {{-- Header Rute --}}
                <h1 class="text-3xl font-bold text-gray-800">{{ $penerbangan->bandaraAsal->kota }} → {{ $penerbangan->bandaraTujuan->kota }}</h1>
                <p class="text-gray-500">{{ $passengers_count }} Penumpang</p>
            </div>


            {{-- Kartu Detail Penerbangan --}}
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <span class="bg-purple-100 text-purple-700 text-sm font-semibold px-4 py-1 rounded-full">Pergi</span>
                    <span class="text-gray-600 font-semibold">{{ \Carbon\Carbon::parse($penerbangan->waktu_berangkat)->isoFormat('dddd, D MMM YYYY') }}</span>
                </div>
                <div class="grid grid-cols-[auto_auto_1fr] gap-x-4">
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($penerbangan->waktu_berangkat)->format('H:i') }}</p>
                    </div>
                    <div class="relative flex-col items-center flex">
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                        <div class="w-0.5 h-full bg-gray-300 my-1"></div>
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                    </div>
                    <div class="space-y-4 pb-4">
                        <p class="font-semibold text-gray-700">{{ $penerbangan->bandaraAsal->nama_bandara }}</p>
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/logo-maskapai/' . Str::slug($penerbangan->maskapai->nama_maskapai) . '.png') }}" alt="Logo" class="h-6">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $penerbangan->maskapai->nama_maskapai }}</p>
                                    <p class="text-sm text-gray-500">{{ $penerbangan->nomor_penerbangan }} • {{ $passengerClass }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">{{ \Carbon\Carbon::parse($penerbangan->waktu_tiba)->format('H:i') }}</p>
                    </div>
                    <div></div>
                    <div>
                        <p class="font-semibold text-gray-700">{{ $penerbangan->bandaraTujuan->nama_bandara }}</p>
                    </div>
                </div>
            </div>

            {{-- Form Penumpang (Tidak ada perubahan) --}}
            <h2 class="text-xl font-bold text-gray-800 mb-4">Isi Detail Penumpang</h2>
            <div class="space-y-4">
                @foreach (range(1, $passengers_count) as $index)
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <p class="text-lg font-bold text-gray-800 mb-4">Penumpang {{ $index }}</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="md:col-span-2">
                                <label for="name_{{ $index }}" class="text-sm font-medium text-gray-600">Nama Lengkap</label>
                                <input type="text" id="name_{{ $index }}" name="passengers[{{ $index - 1 }}][name]" value="{{ old('passengers.' . ($index - 1) . '.name') }}" autocomplete="off" class="mt-1 w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('passengers.' . ($index - 1) . '.name') border-red-500 @enderror" required>
                                @error('passengers.' . ($index - 1) . '.name')<span class="text-sm text-red-500 mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="identity_{{ $index }}" class="text-sm font-medium text-gray-600">Nomor Identitas (KTP/Paspor)</label>
                                <input type="text" id="identity_{{ $index }}" name="passengers[{{ $index - 1 }}][identity_number]" value="{{ old('passengers.' . ($index - 1) . '.identity_number') }}" autocomplete="off" class="mt-1 w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('passengers.' . ($index - 1) . '.identity_number') border-red-500 @enderror" required>
                                @error('passengers.' . ($index - 1) . '.identity_number')<span class="text-sm text-red-500 mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label for="dob_{{ $index }}" class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                                <input type="date" id="dob_{{ $index }}" name="passengers[{{ $index - 1 }}][date_of_birth]" value="{{ old('passengers.' . ($index - 1) . '.date_of_birth') }}" class="mt-1 w-full border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition @error('passengers.' . ($index - 1) . '.date_of_birth') border-red-500 @enderror" required>
                                @error('passengers.' . ($index - 1) . '.date_of_birth')<span class="text-sm text-red-500 mt-1">{{ $message }}</span>@enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                <div class="flex items-center gap-8 mt-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="passengers[{{ $index - 1 }}][gender]" value="Laki-laki" class="form-radio text-purple-600 focus:ring-purple-500" {{ old('passengers.' . ($index - 1) . '.gender') == 'Laki-laki' ? 'checked' : '' }} required>
                                        <span class="text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="passengers[{{ $index - 1 }}][gender]" value="Perempuan" class="form-radio text-purple-600 focus:ring-purple-500" {{ old('passengers.' . ($index - 1) . '.gender') == 'Perempuan' ? 'checked' : '' }} required>
                                        <span class="text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                                @error('passengers.' . ($index - 1) . '.gender')<span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="h-32"></div>

            {{-- Bar Bawah untuk Harga dan Tombol (sticky) --}}
            <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg">
                <div class="max-w-4xl mx-auto p-4 flex justify-between items-center">
                    <div>
                        @php
                            $hargaPerPax = $penerbangan->kelas->firstWhere('jenis_kelas', $passengerClass)->harga ?? 0;
                            $totalHarga = $hargaPerPax * $passengers_count;
                        @endphp
                        <p class="text-sm text-gray-500">Total Harga</p>
                        <p class="text-2xl font-bold text-purple-600">IDR {{ number_format($totalHarga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <button type="submit" class="bg-purple-600 text-white font-bold py-3 px-10 rounded-lg hover:bg-purple-700 transition-colors shadow-md">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection