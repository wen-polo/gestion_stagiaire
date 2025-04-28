@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Faire une demande de stage</h1>
    <form action="{{ route('demande.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="nom" class="block text-gray-700">Nom :</label>
            <input type="text" name="nom" id="nom" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="prenom" class="block text-gray-700">Prénom :</label>
            <input type="text" name="prenom" id="prenom" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="filiere" class="block text-gray-700">Filière / Spécialité :</label>
            <input type="text" name="filiere" id="filiere" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="niveau" class="block text-gray-700">Niveau d'étude :</label>
            <input type="text" name="niveau" id="niveau" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="diplome" class="block text-gray-700">Diplôme :</label>
            <input type="text" name="diplome" id="diplome" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="type_stage" class="block text-gray-700">Type de stage :</label>
            <select name="type_stage" id="type_stage" class="w-full border-gray-300 rounded-lg" required>
                <option value="academique">Académique</option>
                <option value="professionnel">Professionnel</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="statut_stage" class="block text-gray-700">Statut de stage :</label>
            <select name="statut_stage" id="statut_stage" class="w-full border-gray-300 rounded-lg" required>
                <option value="initial">Initial</option>
                <option value="renouvellement">Renouvellement</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="date_debut" class="block text-gray-700">Date de début :</label>
            <input type="date" name="date_debut" id="date_debut" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="date_fin" class="block text-gray-700">Date de fin :</label>
            <input type="date" name="date_fin" id="date_fin" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="contacts" class="block text-gray-700">Contacts :</label>
            <input type="text" name="contacts" id="contacts" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email :</label>
            <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="pdf" class="block text-gray-700">Fichier PDF :</label>
            <input type="file" name="pdf" id="pdf" class="w-full border-gray-300 rounded-lg" accept=".pdf" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Soumettre</button>
    </form>
</div>
@endsection