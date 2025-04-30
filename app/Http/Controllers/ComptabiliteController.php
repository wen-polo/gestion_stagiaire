<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComptabiliteController extends Controller
{
    /**
     * Affiche le tableau de bord de la comptabilité.
     */
    public function dashboard()
    {
        $demandes = DB::table('service_comptabilite')->get(); // Récupérer les données de la table comptabilité
        return view('dashboard.comptabilite', compact('demandes'));
    }

    /**
     * Affiche la liste des tâches.
     */
    public function tasks()
    {
        // Récupérer les tâches pour le service comptabilité
        $tasks = DB::table('tasks')->where('poste', 'comptabilite')->get();

        // Retourner la vue avec les tâches
        return view('dashboard.comptabilite_tasks', compact('tasks'));
    }

    /**
     * Assigne une tâche à un utilisateur.
     */
    public function assignTask(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'userId' => 'required|integer',
            'taskDescription' => 'required|string|max:255',
        ]);

        // Insérer la tâche dans la base de données
        DB::table('tasks')->insert([
            'user_id' => $validated['userId'],
            'description' => $validated['taskDescription'],
            'poste' => 'comptabilite',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
