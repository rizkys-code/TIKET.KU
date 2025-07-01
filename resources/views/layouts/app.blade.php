<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TIKET.KU')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <nav>
        <div class="container">
            <a href="{{ url('/') }}">TIKET.KU</a>
            <ul>
                <li><a href="{{ url('/tickets') }}">Tickets</a></li>
                <li><a href="{{ url('/about') }}">About</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Register</a></li>
                @else
                    <li><a href="#">{{ Auth::user()->name }}</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <main class="container">
        @yield('content')
    </main>
    <footer>
        <div class="container">
            <p>&copy; {{ date('Y') }} TIKET.KU. All rights reserved.</p>
        </div>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>