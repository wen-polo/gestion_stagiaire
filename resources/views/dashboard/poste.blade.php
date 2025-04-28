@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Stagiaires - {{ ucfirst($poste) }}</h1>
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
            @foreach ($stagiaires as $stagiaire)
            <tr>
                <td class="border px-4 py-2">{{ $stagiaire->nom }}</td>
                <td class="border px-4 py-2">{{ $stagiaire->prenom }}</td>
                <td class="border px-4 py-2">{{ $stagiaire->email }}</td>
                <td class="border px-4 py-2">{{ $stagiaire->filiere }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection