<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion Stagiaires')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-white shadow-md py-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold text-blue-600">Gestion Stagiaires</h1>
        </div>
    </header>
    <main class="container mx-auto py-8">
        @yield('content')
    </main>
    <footer class="bg-gray-800 text-white py-4 text-center">
        &copy; 2025 Gestion Stagiaires. Tous droits réservés.
    </footer>
</body>
</html>