@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Tableau de Bord - Service Comptabilité</h1>
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Prénom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Filière</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($demandes as $demande)
            <tr>
                <td class="border px-4 py-2">{{ $demande->nom }}</td>
                <td class="border px-4 py-2">{{ $demande->prenom }}</td>
                <td class="border px-4 py-2">{{ $demande->email }}</td>
                <td class="border px-4 py-2">{{ $demande->filiere }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="border px-4 py-2 text-center">Aucune donnée disponible</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection