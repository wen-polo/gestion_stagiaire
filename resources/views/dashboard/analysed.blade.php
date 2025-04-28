@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Demandes à Confirmer</h1>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Prénom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Filière</th>
                <th class="px-4 py-2">Poste d'Affectation</th>
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
                <td class="border px-4 py-2">{{ $demande->poste_affectation }}</td>
                <td class="border px-4 py-2">
                    @if ($demande->affectation_statut !== 'confirme')
                        <form id="confirmForm-{{ $demande->id }}" action="{{ route('demande.confirmer', $demande->id) }}" method="POST" onsubmit="confirmDemande(event, {{ $demande->id }})">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                Confirmer
                            </button>
                        </form>
                    @else
                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                            Confirmé
                        </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function disableButton(form) {
        console.log('disableButton appelé');
        const button = form.querySelector('button[type="submit"]');
        button.disabled = true;
        button.classList.remove('bg-green-500', 'hover:bg-green-600');
        button.classList.add('bg-gray-400', 'cursor-not-allowed');
        button.textContent = 'Confirmation en cours...';

        // Ne pas empêcher l'envoi du formulaire
    }

    function confirmDemande(event, id) {
        event.preventDefault(); // Empêche le rechargement de la page

        const form = document.getElementById(`confirmForm-${id}`);
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Désactiver le bouton et le rendre gris
                const button = form.querySelector('button[type="submit"]');
                button.disabled = true;
                button.classList.remove('bg-green-500', 'hover:bg-green-600');
                button.classList.add('bg-gray-400', 'cursor-not-allowed');
                button.textContent = 'Confirmé';
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