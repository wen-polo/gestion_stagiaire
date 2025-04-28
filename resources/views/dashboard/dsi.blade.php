@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Tableau de Bord - DSI</h1>
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
            @foreach ($demandes as $demande)
            <tr>
                <td class="border px-4 py-2">{{ $demande->nom }}</td>
                <td class="border px-4 py-2">{{ $demande->prenom }}</td>
                <td class="border px-4 py-2">{{ $demande->email }}</td>
                <td class="border px-4 py-2">{{ $demande->filiere }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection