@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Menu latéral -->
    <aside class="bg-gray-800 text-white w-full md:w-1/4 h-auto md:h-screen p-4">
        <h2 class="text-xl font-bold mb-4">Menu</h2>
        <nav class="space-y-2">
            <a href="{{ route('dashboard.dsi') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Tableau de Bord
            </a>
            <a href="{{ route('dsi.tasks') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Tâches
            </a>
            <a href="{{ route('dsi.documents') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Documents
            </a>
            <a href="{{ route('dsi.logout') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Déconnexion
            </a>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 bg-gray-100 p-6">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-6">Tâches - DSI</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Nom</th>
                            <th class="px-4 py-2 text-left">Prénom</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Filière</th>
                            <th class="px-4 py-2 text-left">Tâche</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($demandes as $demande)
                        <tr class="border-t">
                            <td class="border px-4 py-2">{{ $demande->nom }}</td>
                            <td class="border px-4 py-2">{{ $demande->prenom }}</td>
                            <td class="border px-4 py-2">{{ $demande->email }}</td>
                            <td class="border px-4 py-2">{{ $demande->filiere }}</td>
                            <td class="border px-4 py-2">
                                <button onclick="assignTask({{ $demande->id }})" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Assigner Tâche
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
    function assignTask(id) {
        // Logique pour assigner une tâche
        alert(`Tâche assignée au stagiaire avec l'ID ${id}`);
    }
</script>
@endsection