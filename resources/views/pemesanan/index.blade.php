@extends('layouts.app')

@section('title', 'Detail Pemesanan - Tiket.ku')

@section('content')
    <div class="max-w-4xl mx-auto">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf
            {{-- Input tersembunyi yang dibutuhkan controller --}}
            <input type="hidden" name="penerbangan_id" value="{{ $penerbangan->id }}">
            <input type="hidden" name="passengerClass" value="{{ $passengerClass }}">

            {{-- Bagian Header Rute --}}
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    {{ $penerbangan->bandaraAsal->kota }} → {{ $penerbangan->bandaraTujuan->kota }}
                </h1>
                <p class="text-gray-500">{{ $passengers_count }} Penumpang</p>
            </div>

            {{-- Kartu Detail Penerbangan (Seperti Desain Tiket.com) --}}
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mb-8">
                <div class="flex justify-between items-center mb-4">
                    <span class="bg-purple-100 text-purple-700 text-sm font-semibold px-4 py-1 rounded-full">Pergi</span>
                    <span
                        class="text-gray-600 font-semibold">{{ \Carbon\Carbon::parse($penerbangan->waktu_berangkat)->isoFormat('dddd, D MMM YYYY') }}</span>
                </div>

                {{-- Layout Timeline --}}
                <div class="grid grid-cols-[auto_auto_1fr] gap-x-4">
                    <!-- Kolom 1: Waktu -->
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">
                            {{ \Carbon\Carbon::parse($penerbangan->waktu_berangkat)->format('H:i') }}</p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($penerbangan->waktu_berangkat)->isoFormat('D MMM') }}</p>
                    </div>
                    <!-- Kolom 2: Garis Timeline -->
                    <div class="relative flex-col items-center flex">
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                        <div class="w-0.5 h-full bg-gray-300 my-1"></div>
                        <div class="w-4 h-4 bg-gray-300 rounded-full"></div>
                    </div>
                    <!-- Kolom 3: Detail -->
                    <div class="space-y-4 pb-4">
                        <p class="font-semibold text-gray-700">{{ $penerbangan->bandaraAsal->nama_bandara }}</p>

                        {{-- Kartu Detail Maskapai (Nested) --}}
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/logo-maskapai/' . Str::slug($penerbangan->maskapai->nama_maskapai) . '.png') }}"
                                    alt="Logo" class="h-6">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $penerbangan->maskapai->nama_maskapai }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $penerbangan->nomor_penerbangan }} • {{ $passengerClass }} •
                                        {{ \Carbon\Carbon::parse($penerbangan->waktu_berangkat)->diff(\Carbon\Carbon::parse($penerbangan->waktu_tiba))->format('%hh %im') }}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div>
                                <h4 class="font-semibold text-gray-800 mb-3">Tiket Sudah Termasuk</h4>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p class="flex items-center gap-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m12 3V9" />
                                        </svg>
                                        <span>Kabin: 7 kg</span>
                                    </p>
                                    <p class="flex items-center gap-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                        <span>Bagasi: 15 kg (Opsional)</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Waktu dan Bandara Tiba -->
                    <div class="text-right">
                        <p class="font-bold text-lg text-gray-800">
                            {{ \Carbon\Carbon::parse($penerbangan->waktu_tiba)->format('H:i') }}</p>
                        <p class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($penerbangan->waktu_tiba)->isoFormat('D MMM') }}</p>
                    </div>
                    <div></div>
                    <div>
                        <p class="font-semibold text-gray-700">{{ $penerbangan->bandaraTujuan->nama_bandara }}</p>
                    </div>
                </div>
            </div>

            {{-- Kartu Form Detail Penumpang --}}
            <h2 class="text-xl font-bold text-gray-800 mb-4">Isi Detail Penumpang</h2>
            <div class="space-y-4">
                @foreach (range(1, $passengers_count) as $index)
                    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
                        <p class="text-lg font-bold text-gray-800 mb-4">Penumpang {{ $index }}</p>
                        {{-- Form untuk setiap penumpang --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="md:col-span-2">
                                <label for="name_{{ $index }}" class="text-sm font-medium text-gray-600">Nama
                                    Lengkap</label>
                                <input type="text" id="name_{{ $index }}"
                                    name="passengers[{{ $index - 1 }}][name]"
                                    value="{{ old('passengers.' . ($index - 1) . '.name') }}"
                                    class="mt-1 w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                    required>
                                @error('passengers.' . ($index - 1) . '.name')
                                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="identity_{{ $index }}" class="text-sm font-medium text-gray-600">Nomor
                                    Identitas (KTP/Paspor)</label>
                                <input type="text" id="identity_{{ $index }}"
                                    name="passengers[{{ $index - 1 }}][identity_number]"
                                    value="{{ old('passengers.' . ($index - 1) . '.identity_number') }}"
                                    class="mt-1 w-full border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                    required>
                                @error('passengers.' . ($index - 1) . '.identity_number')
                                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="dob_{{ $index }}" class="text-sm font-medium text-gray-600">Tanggal
                                    Lahir</label>
                                <input type="date" id="dob_{{ $index }}"
                                    name="passengers[{{ $index - 1 }}][date_of_birth]"
                                    value="{{ old('passengers.' . ($index - 1) . '.date_of_birth') }}"
                                    class="mt-1 w-full border-gray-300 rounded-lg p-3 text-gray-700 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                    required>
                                @error('passengers.' . ($index - 1) . '.date_of_birth')
                                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                                <div class="flex items-center gap-8 mt-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="passengers[{{ $index - 1 }}][gender]"
                                            value="Laki-laki" class="form-radio text-purple-600 focus:ring-purple-500"
                                            {{ old('passengers.' . ($index - 1) . '.gender') == 'Laki-laki' ? 'checked' : '' }}
                                            required>
                                        <span class="text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="passengers[{{ $index - 1 }}][gender]"
                                            value="Perempuan" class="form-radio text-purple-600 focus:ring-purple-500"
                                            {{ old('passengers.' . ($index - 1) . '.gender') == 'Perempuan' ? 'checked' : '' }}
                                            required>
                                        <span class="text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                                @error('passengers.' . ($index - 1) . '.gender')
                                    <span class="text-sm text-red-500 mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Spacer untuk memberi ruang sebelum bar bawah --}}
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
                        <p class="text-2xl font-bold text-purple-600">
                            IDR {{ number_format($totalHarga, 0, ',', '.') }}
                        </p>
                    </div>
                    <div>
                        <button type="submit"
                            class="bg-purple-600 text-white font-bold py-3 px-10 rounded-lg hover:bg-purple-700 transition-colors shadow-md">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection
