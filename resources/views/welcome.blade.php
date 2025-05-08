<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de Vendas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container text-center my-auto py-5">
        <h1 class="display-4 fw-bold mb-4">Sistema de Vendas</h1>

        <header class="mb-5">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-danger mx-2">Home</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary mx-2">Entrar</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary mx-2">Cadastrar</a>
                    @endif
                @endauth
            @endif
        </header>

        <main class="mb-5">
            <p class="lead">Bem-vindo ao Sistema de Vendas! Gerencie suas vendas de forma simples e eficiente.</p>
        </main>

        <footer class="text-muted small mt-auto pt-5">
            <p>Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
            <p>Desenvolvido por <strong>João Victor N. Doratioto</strong></p>
            <p>
                <a href="https://github.com/joaovictor-nogueira/Sistema-Vendas" target="_blank"
                    class="text-decoration-underline text-dark">
                    GitHub: joaovictor-nogueira
                </a>
            </p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
