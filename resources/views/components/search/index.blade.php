@extends('layouts.app')

@section('title', 'Cari Tiket Pesawat Murah - TIKET.KU')

@section('content')
<div class="max-w-4xl mx-auto" x-data="flightSearch()">
    <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800">Pesan Tiket Pesawat Murah</h1>
        <p class="text-lg text-gray-500 mt-2">Jelajahi dunia dengan penawaran terbaik dari Tiket.Ku</p>
    </div>

    {{-- KARTU FORM PENCARIAN --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
        <form method="GET" action="{{ route('jadwal') }}">
            {{-- Baris 1: Asal & Tujuan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-4 items-center mb-4">
                <div class="relative">
                    <label class="text-sm font-semibold text-gray-500">Dari</label>
                    <input type="text" name="from" x-model="from" placeholder="Kota atau bandara asal" class="w-full mt-1 p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-tiket-purple focus:border-tiket-purple transition">
                </div>
                <div class="relative mt-4 md:mt-0">
                    <label class="text-sm font-semibold text-gray-500">Ke</label>
                    <input type="text" name="to" x-model="to" placeholder="Kota atau bandara tujuan" class="w-full mt-1 p-4 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-tiket-purple focus:border-tiket-purple transition">
                </div>
            </div>

            {{-- Baris 2: Tanggal, Penumpang & Kelas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="text-sm font-semibold text-gray-500">Tanggal Pergi</label>
                    {{-- DIUBAH: Menambahkan x-ref untuk diakses oleh Alpine --}}
                    <input type="text" id="datepicker" x-ref="datepicker" name="date" class="w-full cursor-pointer mt-1 p-4 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-tiket-purple focus:border-tiket-purple transition" readonly>
                </div>

                {{-- Penumpang --}}
                <div class="relative">
                    <label class="text-sm font-semibold text-gray-500">Penumpang</label>
                     <!-- Hidden inputs untuk submit data penumpang -->
                    <input type="hidden" name="passengers[adult]" :value="passengers.adult">
                    <input type="hidden" name="passengers[child]" :value="passengers.child">
                    <input type="hidden" name="passengers[infant]" :value="passengers.infant">
                    <button type="button" @click="passengerPickerOpen = !passengerPickerOpen" class="w-full text-left mt-1 p-4 bg-white border-2 border-gray-200 rounded-xl">
                        {{-- DIUBAH: Menambahkan hitungan bayi --}}
                        <span x-text="`${passengers.adult + passengers.child + passengers.infant} Penumpang`"></span>
                    </button>
                    <div x-show="passengerPickerOpen" @click.away="passengerPickerOpen = false" x-transition class="absolute top-full mt-2 w-full bg-white rounded-xl shadow-lg p-4 z-10" style="display: none;">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <div><p class="font-semibold">Dewasa</p><p class="text-xs text-gray-500">(12+ thn)</p></div>
                                <div class="flex items-center space-x-3">
                                    <button type="button" @click="passengers.adult > 1 ? passengers.adult-- : null" class="w-8 h-8 border rounded-full text-lg font-bold text-gray-500 flex items-center justify-center">-</button>
                                    <span x-text="passengers.adult" class="w-5 text-center font-semibold"></span>
                                    <button type="button" @click="passengers.adult++" class="w-8 h-8 border rounded-full text-lg font-bold text-tiket-blue flex items-center justify-center">+</button>
                                </div>
                            </div>
                             <div class="flex justify-between items-center">
                                <div><p class="font-semibold">Anak</p><p class="text-xs text-gray-500">(2-11 thn)</p></div>
                                <div class="flex items-center space-x-3">
                                    <button type="button" @click="passengers.child > 0 ? passengers.child-- : null" class="w-8 h-8 border rounded-full text-lg font-bold text-gray-500 flex items-center justify-center">-</button>
                                    <span x-text="passengers.child" class="w-5 text-center font-semibold"></span>
                                    <button type="button" @click="passengers.child++" class="w-8 h-8 border rounded-full text-lg font-bold text-tiket-blue flex items-center justify-center">+</button>
                                </div>
                            </div>
                             {{-- DITAMBAHKAN: Opsi untuk bayi --}}
                             <div class="flex justify-between items-center">
                                <div><p class="font-semibold">Bayi</p><p class="text-xs text-gray-500">(< 2 thn)</p></div>
                                <div class="flex items-center space-x-3">
                                    <button type="button" @click="passengers.infant > 0 ? passengers.infant-- : null" class="w-8 h-8 border rounded-full text-lg font-bold text-gray-500 flex items-center justify-center">-</button>
                                    <span x-text="passengers.infant" class="w-5 text-center font-semibold"></span>
                                    <button type="button" @click="passengers.infant++" class="w-8 h-8 border rounded-full text-lg font-bold text-tiket-blue flex items-center justify-center">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kelas Penerbangan --}}
                <div>
                     <label class="text-sm font-semibold text-gray-500">Kelas Kabin</label>
                     <select name="passengerClass" x-model="passengerClass" class="w-full mt-1 p-4 bg-white border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-tiket-purple focus:border-tiket-purple transition">
                        <option>Ekonomi</option>
                        <option>Bisnis</option>
                        <option>First Class</option>
                    </select>
                </div>
            </div>

            {{-- Tombol Cari --}}
            <div class="flex justify-end">
                <button type="submit" class="w-full md:w-auto bg-tiket-blue hover:bg-tiket-blue-darker text-white font-bold text-lg py-4 px-12 rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                    Cari Tiket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function flightSearch() {
        return {
            from: 'Jakarta',
            to: 'Denpasar-Bali',
            passengerClass: 'Ekonomi',
            passengers: { adult: 1, child: 0, infant: 0 },
            passengerPickerOpen: false,

            // DIUBAH: Logika inisialisasi datepicker diperbaiki
            init() {
                // Set tanggal default (7 hari dari sekarang)
                const defaultDate = new Date();
                defaultDate.setDate(defaultDate.getDate() + 7);

                const picker = new Litepicker({
                    element: this.$refs.datepicker, // Menggunakan x-ref
                    singleMode: true,
                    allowRepick: true,
                    minDate: new Date(),
                    format: 'DD MMMM YYYY',
                    lang: 'id-ID',
                    buttonText: { apply: 'Pilih', cancel: 'Batal' },
                });
                
                // Set tanggal di picker dan di input field secara langsung
                picker.setDate(defaultDate);
            }
        }
    }
</script>
@endpush