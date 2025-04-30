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
                                <button onclick="openTaskModal({{ $demande->id }})" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
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

<!-- Modale pour l'assignation des tâches -->
<div id="taskModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/2">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold">Assigner une Tâche</h2>
        </div>
        <div class="p-4">
            <form id="taskForm">
                @csrf
                <input type="hidden" id="userId" name="userId">
                <div class="mb-4">
                    <label for="taskTitle" class="block text-gray-700">Titre de la Tâche</label>
                    <input type="text" id="taskTitle" name="taskTitle" class="w-full border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="taskDescription" class="block text-gray-700">Description</label>
                    <textarea id="taskDescription" name="taskDescription" class="w-full border-gray-300 rounded px-4 py-2" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="taskDeadline" class="block text-gray-700">Date Limite</label>
                    <input type="date" id="taskDeadline" name="taskDeadline" class="w-full border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="taskTime" class="block text-gray-700">Temps Limite (HH:MM)</label>
                    <input type="time" id="taskTime" name="taskTime" class="w-full border-gray-300 rounded px-4 py-2" required>
                </div>
                <div class="text-right">
                    <button type="button" onclick="closeTaskModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Assigner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openTaskModal(userId) {
        document.getElementById('userId').value = userId;
        document.getElementById('taskModal').classList.remove('hidden');
    }

    function closeTaskModal() {
        document.getElementById('taskModal').classList.add('hidden');
    }

    document.getElementById('taskForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('/dsi/assign-task', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Tâche assignée avec succès.');
                closeTaskModal();
            } else {
                alert('Une erreur est survenue : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur :', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    });
</script>
@endsection