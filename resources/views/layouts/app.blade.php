<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TIKET.KU')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tiket-purple': '#8A2BE2',
                        'tiket-yellow': '#FFAF00',
                        'tiket-blue': '#3b82f6',
                        'tiket-blue-darker': '#2563eb',
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F9FA;
            /* Sedikit abu-abu seperti di gambar */
        }

        /* Style untuk Litepicker agar menyatu dengan tema */
        .litepicker {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 12px !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1) !important;
        }
    </style>

    @stack('styles')
</head>

<body class="text-gray-800">
    <div class=" mx-auto px-4 sm:px-6 lg:px-1 py-8">
        @yield('content')
    </div>

    <!-- Litepicker JS -->
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script>

    <!-- Alpine.js untuk Interaktivitas (Sangat mudah untuk dropdown, dll) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>

</html>
