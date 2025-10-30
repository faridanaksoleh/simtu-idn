<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Selamat Datang - SIMTU IDN</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="antialiased font-sans">
        
        <div class="flex flex-col items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 px-4 py-8">
            
            <div class="w-full sm:max-w-md bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                
                <div class="flex flex-col items-center mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo SIMTU" class="w-16 mb-3">
                    <h2 class="text-2xl font-semibold text-gray-700">Selamat Datang</h2>
                    <p class="text-sm text-gray-500 mt-1">di <strong>SIMTU IDN</strong></p>
                </div>

                <div class="text-center text-gray-600 my-8">
                    <p>
                        Aplikasi Anda telah siap. Silakan masuk untuk melanjutkan ke dashboard Anda atau mendaftar jika Anda belum memiliki akun.
                    </p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    @if (Route::has('login'))
                        <div class="flex items-center justify-center space-x-4">
                            <a 
                                wire:navigate 
                                href="{{ route('login') }}" 
                                class="py-2 px-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition duration-150 ease-in-out"
                            >
                                Masuk
                            </a>
                            
                            @if (Route::has('register'))
                                <a 
                                    wire:navigate 
                                    href="{{ route('register') }}" 
                                    class="py-2 px-6 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg shadow-sm border border-gray-200 transition duration-150 ease-in-out"
                                >
                                    Daftar
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

            </div>

            <p class="mt-6 text-gray-400 text-xs">
                © {{ date('Y') }} SIMTU IDN. All Rights Reserved.
            </p>
        </div>

    </body>
</html>