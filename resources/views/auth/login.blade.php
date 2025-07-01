<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Tiket.Ku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tiket-blue': '#0064d2',
                        'tiket-blue-darker': '#0052ad',
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    <div class="flex items-center justify-center min-h-screen">
        <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
            <div class="flex flex-col justify-center p-8 md:p-14">
                <span class="mb-3 text-4xl font-bold text-tiket-blue">Tiket.Ku</span>
                <span class="font-light text-gray-500 mb-8">
                    Selamat datang kembali! Silakan masuk ke akun Anda.
                </span>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="py-4">
                        <label for="email" class="mb-2 text-md font-medium text-gray-700">Alamat Email</label>
                        <input type="email" name="email" id="email"
                               class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-tiket-blue @error('email') border-red-500 @enderror"
                               value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="py-4">
                        <label for="password" class="mb-2 text-md font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password"
                               class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-tiket-blue @error('password') border-red-500 @enderror"
                               required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between w-full py-4">
                        <div class="mr-24">
                            <input type="checkbox" name="remember" id="remember" class="mr-2">
                            <label for="remember" class="text-md">Ingat Saya</label>
                        </div>
                        <a href="#" class="font-bold text-sm text-tiket-blue hover:underline">Lupa Password?</a>
                    </div>
                    
                    <button type="submit" class="w-full bg-tiket-blue text-white p-2 rounded-lg mb-6 hover:bg-tiket-blue-darker focus:outline-none focus:ring-4 focus:ring-blue-300 font-semibold">
                        Login
                    </button>

                    <div class="text-center text-gray-500">
                        Belum punya akun?
                        <a href="#" class="font-bold text-tiket-blue hover:underline">Daftar sekarang</a>
                    </div>
                </form>
            </div>

            <div class="relative hidden md:block">
                <img src="https://images.unsplash.com/photo-1579532537598-459ecdaf39cc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80"
                     alt="img"
                     class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover">
            </div>
        </div>
    </div>
</body>
</html>