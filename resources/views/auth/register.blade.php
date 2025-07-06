<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - Tiket.Ku</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    
    <div class="flex items-center justify-center min-h-screen">
        <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0">
            <div class="flex flex-col justify-center p-8 md:p-14">
                <span class="mb-3 text-4xl font-bold text-tiket-purple">Tiket<span class="text-[#FFAF00]">.</span><span
                        class="text-black">Ku</span></span>
                <span class="font-light text-gray-500 mb-8">
                    Buat akun baru untuk memulai petualangan Anda.
                </span>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="py-4">
                        <label for="name" class="mb-2 text-md font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                            class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-tiket-blue @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="py-4">
                        <label for="email" class="mb-2 text-md font-medium text-gray-700">Alamat Email</label>
                        <input type="email" name="email" id="email"
                            class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-tiket-blue @error('email') border-red-500 @enderror"
                            value="{{ old('email') }}" required>
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

                    <div class="py-4">
                        <label for="password_confirmation" class="mb-2 text-md font-medium text-gray-700">Konfirmasi
                            Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full p-2 border border-gray-300 rounded-md placeholder:font-light placeholder:text-gray-500 focus:outline-none focus:ring-1 focus:ring-tiket-blue"
                            required>
                    </div>

                    <button type="submit"
                        class="w-full bg-tiket-blue text-white p-2 rounded-lg my-6 hover:bg-tiket-blue-darker focus:outline-none focus:ring-4 focus:ring-blue-300 font-semibold">
                        Daftar
                    </button>

                    <div class="text-center text-gray-500">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-tiket-blue hover:underline">Login
                            sekarang</a>
                    </div>
                </form>
            </div>

            <div class="relative hidden md:block">
                <img src="https://images.unsplash.com/photo-1615400492808-b9bd8c910e26?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fHBlc2F3YXR8ZW58MHx8MHx8fDA%3D"
                    alt="img" class="w-[400px] h-full hidden rounded-r-2xl md:block object-cover">
            </div>
        </div>
    </div>
</body>

</html>
