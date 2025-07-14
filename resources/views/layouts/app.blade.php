<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TIKET.KU')</title>

    {{-- Tailwind CSS dari CDN dengan Konfigurasi --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tiket-purple': '#8A2BE2', // Warna ungu yang lebih vibrant
                        'tiket-yellow': '#FFAF00',
                        'tiket-blue': '#3b82f6',
                        'tiket-blue-darker': '#2563eb',
                    }
                }
            }
        }
    </script>

    {{-- Font Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- CSS Litepicker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F9FA;
        }

        .litepicker {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1) !important;
        }
    </style>

    @stack('styles')
</head>

<body class="text-gray-800">

    <div class="container mx-auto px-4 py-6">
        <header class="flex justify-between items-center mb-8">
            <a href="{{ route('jadwal') }}">
                <span class="text-4xl font-extrabold text-tiket-purple">Tiket<span
                        class="text-tiket-yellow">.</span><span class="text-gray-800">Ku</span></span>
            </a>
            
            {{-- ========================================================== --}}
            {{-- === PERUBAHAN UTAMA DI SINI                            === --}}
            {{-- ========================================================== --}}
            @auth
                {{-- Menggunakan flexbox untuk menata item dengan rapi --}}
                <div class="flex items-center space-x-6">
                    <span class="text-gray-600">Halo, {{ Auth::user()->name }}</span>
                    
                    {{-- Link Riwayat Pemesanan --}}
                    <a href="{{ route('riwayat.index') }}" class="font-semibold text-tiket-purple hover:underline">
                        Riwayat
                    </a>

                    {{-- Form Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-2 px-4 rounded-lg text-sm transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
            {{-- ========================================================== --}}
            
        </header>

        <main>
            @yield('content')
        </main>
    </div>

    {{-- JS Litepicker & Alpine.js --}}
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>

</html>