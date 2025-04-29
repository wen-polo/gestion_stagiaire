@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Connexion</h1>
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email :</label>
            <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Mot de passe :</label>
            <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-lg" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg">Se connecter</button>
    </form>
</div>
@endsection