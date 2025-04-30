@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Menu latéral -->
    <aside class="bg-gray-800 text-white w-full md:w-1/4 h-auto md:h-screen p-4">
        <h2 class="text-xl font-bold mb-4">Menu</h2>
        <nav class="space-y-2">
            <a href="{{ route('stagiaire.dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Tableau de Bord
            </a>
            <a href="{{ route('stagiaire.profile') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Profil
            </a>
            <a href="{{ route('stagiaire.documents') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Mes Documents
            </a>
            <a href="{{ route('stagiaire.logout') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Déconnexion
            </a>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 bg-gray-100 p-6">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-6">Profil de {{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <p class="mb-4"><strong>Email :</strong> {{ $stagiaire->email }}</p>
                <p class="mb-4"><strong>Filière :</strong> {{ $stagiaire->filiere }}</p>
                <p class="mb-4"><strong>Poste :</strong> {{ ucfirst($poste) }}</p>
                <h2 class="text-xl font-bold mb-4">Tâches Assignées</h2>
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Titre</th>
                            <th class="px-4 py-2 text-left">Description</th>
                            <th class="px-4 py-2 text-left">Date Limite</th>
                            <th class="px-4 py-2 text-left">Heure Limite</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                        <tr>
                            <td class="border px-4 py-2">{{ $task->title }}</td>
                            <td class="border px-4 py-2">{{ $task->description }}</td>
                            <td class="border px-4 py-2">{{ $task->deadline_date }}</td>
                            <td class="border px-4 py-2">{{ $task->deadline_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection