<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de Vendas</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white px-4">
                <div class="w-full max-w-3xl">
                    <h1 class="text-4xl font-bold text-center mb-8 text-black dark:text-white">Sistema de Vendas</h1>
                    <header class="flex justify-center space-x-4 mb-10">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="px-4 py-2 rounded-md text-white bg-[#FF2D20] hover:bg-red-600 transition">
                                    Home
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-white bg-gray-700 hover:bg-gray-800 transition">
                                    Entrar
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-white bg-gray-700 hover:bg-gray-800 transition">
                                        Cadastrar
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </header>

                    <main class="text-center text-lg text-black dark:text-white">
                        <p>Bem-vindo ao Sistema de Vendas. Gerencie suas vendas de forma simples e eficiente.</p>
                    </main>

                    <footer class="mt-16 text-center text-sm text-black dark:text-white/70 space-y-2">
                        <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
                        <p>Desenvolvido por <strong>João Victor N. Doratioto</strong></p>
                        <p>
                            <a href="https://github.com/joaovictor-nogueira/Sistema-Vendas" target="_blank" class="underline hover:text-[#FF2D20] transition">
                                GitHub: joaovictor-nogueira
                            </a>
                        </p>
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
