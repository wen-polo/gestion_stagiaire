@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    <!-- Menu latéral -->
    <aside class="bg-gray-800 text-white w-full md:w-1/4 h-auto md:h-screen p-4">
        <h2 class="text-xl font-bold mb-4">Menu</h2>
        <nav class="space-y-2">
            <a href="{{ route('dashboard.dpaf_post') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Dashboard
            </a>
            <a href="{{ route('demande.tasks') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Tâches
            </a>
            <a href="{{ route('dpaf.tasks') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                Tâches
            </a>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 bg-gray-100 p-6">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold mb-6">Tableau de Bord - DPAF</h1>
            <div class="bg-white shadow-md rounded-lg p-6">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Nom</th>
                            <th class="px-4 py-2 text-left">Prénom</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Filière</th>
                            <th class="px-4 py-2 text-left">Détail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($demandes as $demande)
                        <tr class="border-t">
                            <td class="border px-4 py-2">{{ $demande->nom }}</td>
                            <td class="border px-4 py-2">{{ $demande->prenom }}</td>
                            <td class="border px-4 py-2">{{ $demande->email }}</td>
                            <td class="border px-4 py-2">{{ $demande->filiere }}</td>
                            <td class="border px-4 py-2">
                                <button onclick="openModalDpaf({{ $demande->id }})" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                    Voir Détail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="border px-4 py-2 text-center">Aucune donnée disponible</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modale -->
<div id="detailModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg w-1/2">
        <div class="p-4 border-b">
            <h2 class="text-xl font-bold">Détails du Stagiaire</h2>
        </div>
        <div class="p-4">
            <p><strong>Nom :</strong> <span id="modalNom"></span></p>
            <p><strong>Prénom :</strong> <span id="modalPrenom"></span></p>
            <p><strong>Email :</strong> <span id="modalEmail"></span></p>
            <p><strong>Filière :</strong> <span id="modalFiliere"></span></p>
            <p><strong>Date de début :</strong> <span id="modalDateDebut"></span></p>
            <p><strong>Date de fin :</strong> <span id="modalDateFin"></span></p>
            <div class="mt-4">
                <label for="progressBar" class="block text-gray-700">Progression :</label>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div id="progressBar" class="bg-blue-500 h-4 rounded-full"></div>
                </div>
            </div>
        </div>
        <div class="p-4 border-t text-right">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>
    function openModalDpaf(id) {
        fetch(`/dpaf/demande/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                    return;
                }

                // Mettre à jour les champs de la modale avec les données récupérées
                document.getElementById('modalNom').textContent = data.nom;
                document.getElementById('modalPrenom').textContent = data.prenom;
                document.getElementById('modalEmail').textContent = data.email;
                document.getElementById('modalFiliere').textContent = data.filiere;
                document.getElementById('modalDateDebut').textContent = data.date_debut;
                document.getElementById('modalDateFin').textContent = data.date_fin;

                // Calculer la progression
                const startDate = new Date(data.date_debut);
                const endDate = new Date(data.date_fin);
                const today = new Date();
                const totalDuration = endDate - startDate;
                const elapsedDuration = today - startDate;
                const progress = Math.min((elapsedDuration / totalDuration) * 100, 100);

                // Mettre à jour la barre de progression
                const progressBar = document.getElementById('progressBar');
                progressBar.style.width = `${progress}%`;

                // Afficher la modale
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données :', error);
                alert('Impossible de charger les détails du stagiaire.');
            });
    }

    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@endsection