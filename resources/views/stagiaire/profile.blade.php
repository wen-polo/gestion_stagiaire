@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Profil de {{ $stagiaire->prenom }} {{ $stagiaire->nom }}</h1>
    <p><strong>Email :</strong> {{ $stagiaire->email }}</p>
    <p><strong>Filière :</strong> {{ $stagiaire->filiere }}</p>
    <p><strong>Poste :</strong> {{ ucfirst($poste) }}</p>
</div>
@endsection