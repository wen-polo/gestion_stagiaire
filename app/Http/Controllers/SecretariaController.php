<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SecretariaController extends Controller
{
    /**
     * Affiche le tableau de bord des tâches pour Secretaria.
     */
    public function tasks()
    {
        // Récupérer les stagiaires de la table `secretaria`
        $demandes = DB::table('secretaria')->get();

        // Récupérer les tâches liées au poste Secretaria
        $tasks = DB::table('tasks')->where('poste', 'secretaria')->get();

        // Retourner la vue avec les stagiaires et les tâches
        return view('dashboard.secretaria_tasks', compact('demandes', 'tasks'));
    }

    /**
     * Assigne une tâche à un stagiaire.
     */
    public function assignTask(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required|exists:secretaria,id', // Vérifie que l'ID existe dans la table `secretaria`
            'taskDescription' => 'required|string|max:255',
        ]);

        try {
            DB::table('tasks')->insert([
                'user_id' => $validated['userId'],
                'description' => $validated['taskDescription'],
                'poste' => 'secretaria',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'assignation de la tâche : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue.']);
        }
    }

    /**
     * Marque une tâche comme terminée.
     */
    public function completeTask($id)
    {
        DB::table('tasks')->where('id', $id)->update(['completed_at' => now()]);

        return response()->json(['success' => true]);
    }
}
