@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Tableau de Bord - Secrétariat Général</h1>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Nom</th>
                <th class="px-4 py-2">Prénom</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($demandes as $demande)
            <tr>
                <td class="border px-4 py-2">{{ $demande->nom }}</td>
                <td class="border px-4 py-2">{{ $demande->prenom }}</td>
                <td class="border px-4 py-2">{{ $demande->email }}</td>
                <td class="border px-4 py-2">
                    @if ($demande->statut === 'transferee_sg')
                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                            Transféré
                        </button>
                    @else
                        <form action="{{ route('demande.transferer.sg', $demande->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Transférer au DPAF
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection