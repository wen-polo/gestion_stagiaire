@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Tableau de Bord - SRHDS</h1>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Prénom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Filière</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($demandes as $demande)
            <tr>
                <td class="border px-4 py-2">{{ $demande->nom }}</td>
                <td class="border px-4 py-2">{{ $demande->prenom }}</td>
                <td class="border px-4 py-2">{{ $demande->email }}</td>
                <td class="border px-4 py-2">{{ $demande->filiere }}</td>
                <td class="border px-4 py-2">
                    <form id="affectationForm-{{ $demande->id }}" onsubmit="submitAffectation(event, {{ $demande->id }})">
                        @csrf
                        <select name="poste_affectation" class="border-gray-300 rounded">
                            <option value="Secretaria" {{ $demande->poste_affectation === 'Secretaria' ? 'selected' : '' }}>Secretaria</option>
                            <option value="DSI" {{ $demande->poste_affectation === 'DSI' ? 'selected' : '' }}>DSI</option>
                            <option value="Service Comptabilité" {{ $demande->poste_affectation === 'Service Comptabilité' ? 'selected' : '' }}>Service Comptabilité</option>
                            <option value="DPAF" {{ $demande->poste_affectation === 'DPAF' ? 'selected' : '' }}>DPAF</option>
                        </select>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Affecter
                        </button>
                    </form>
                </td>
                <td class="border px-4 py-2">
                    <!-- Bouton Détail -->
                    <button onclick="openModal({{ $demande->id }})" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Détail
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
            <p><strong>Niveau :</strong> <span id="modalNiveau"></span></p>
            <p><strong>Diplôme :</strong> <span id="modalDiplome"></span></p>
            <p><strong>PDF :</strong> <a id="modalPdfLink" href="#" target="_blank" class="text-blue-500 hover:underline">Voir le PDF</a></p>
            <!-- Optionnel : Aperçu du PDF -->
            <iframe id="modalPdfPreview" src="" class="w-full h-64 mt-4 hidden"></iframe>
        </div>
        <div class="p-4 border-t text-right">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Fermer
            </button>
        </div>
    </div>
</div>

<script>
    // Fonction pour ouvrir la modale
    function openModal(id) {
        // Récupérer les données du stagiaire via une requête AJAX
        fetch(`/demande/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalNom').textContent = data.nom;
                document.getElementById('modalPrenom').textContent = data.prenom;
                document.getElementById('modalEmail').textContent = data.email;
                document.getElementById('modalFiliere').textContent = data.filiere;
                document.getElementById('modalNiveau').textContent = data.niveau;
                document.getElementById('modalDiplome').textContent = data.diplome;

                // Lien vers le PDF
                const pdfUrl = `/storage/${data.pdf_path}`;
                document.getElementById('modalPdfLink').href = pdfUrl;

                // Optionnel : Aperçu du PDF
                const pdfPreview = document.getElementById('modalPdfPreview');
                pdfPreview.src = pdfUrl;
                pdfPreview.classList.remove('hidden');

                // Afficher la modale
                document.getElementById('detailModal').classList.remove('hidden');
            });
    }

    // Fonction pour fermer la modale
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    function submitAffectation(event, id) {
        event.preventDefault(); // Empêcher le rechargement de la page

        const form = document.getElementById(`affectationForm-${id}`);
        const formData = new FormData(form);

        fetch(`/demande/${id}/affecter`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Réponse du serveur :', data); // Log pour vérifier la réponse
            if (data.success) {
                alert(`Stagiaire affecté avec succès au poste : ${data.poste_affectation}`);

                // Désactiver le bouton et le rendre gris
                const button = form.querySelector('button[type="submit"]');
                button.disabled = true;
                button.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                button.classList.add('bg-gray-400', 'cursor-not-allowed');
                button.textContent = 'Affecté';
            } else {
                alert(data.message || 'Une erreur est survenue.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        });
    }
</script>
@endsection
