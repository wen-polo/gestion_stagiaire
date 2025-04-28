<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Stagiaires</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="text-2xl font-bold text-blue-600">Gestion Stagiaires</a>
            
            <!-- Menu -->
            <ul class="flex space-x-6">
                <li><a href="#" class="text-gray-600 hover:text-blue-600">Accueil</a></li>
                <li><a href="#" class="text-gray-600 hover:text-blue-600">Demandes</a></li>
                <li><a href="#" class="text-gray-600 hover:text-blue-600">Tâches</a></li>
                <li><a href="#" class="text-gray-600 hover:text-blue-600">Documents</a></li>
                <li><a href="#" class="text-gray-600 hover:text-blue-600">Contact</a></li>
            </ul>

            <!-- Profile -->
            <div class="flex items-center space-x-4">
                <img src="https://via.placeholder.com/40" alt="Profile" class="w-10 h-10 rounded-full">
                <span class="text-gray-600">Bonjour, Invité</span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-20">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Bienvenue sur la plateforme de gestion des stagiaires</h1>
            <p class="text-lg mb-6">Envoyez vos demandes de stage, gérez vos tâches et vos documents en toute simplicité.</p>
            <a href="{{ route('demande.create') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg shadow-md hover:bg-gray-100">
                Demande de Stage
            </a>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">Nos Fonctionnalités</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Gestion des Demandes</h3>
                    <p class="text-gray-600">Soumettez vos demandes de stage en ligne et suivez leur statut.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Tâches Assignées</h3>
                    <p class="text-gray-600">Interagissez avec les tâches assignées par les administrateurs.</p>
                </div>
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Génération de CV</h3>
                    <p class="text-gray-600">Créez automatiquement des CV professionnels à partir de vos données.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2025 Gestion Stagiaires. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
