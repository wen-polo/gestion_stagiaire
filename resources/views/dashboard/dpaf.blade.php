@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <!-- Barre de menu -->
    <nav class="bg-white shadow-md mb-6">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div>
                <a href="{{ route('dashboard.dpaf') }}" class="text-blue-600 font-bold text-lg hover:underline">
                    Dashboard
                </a>
                <a href="{{ route('demande.analysed') }}" class="ml-6 text-gray-600 hover:text-blue-600">
                    Demande Analysée
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <h1 class="text-2xl font-bold mb-6">Tableau de Bord - DPAF</h1>
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
                    @if ($demande->statut === 'transferee_dpaf')
                        <button class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed" disabled>
                            Transféré
                        </button>
                    @else
                        <form action="{{ route('demande.transfererDpaf', $demande->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Transférer au SRHDS
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

