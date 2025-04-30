<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DsiController extends Controller
{
    public function tasks()
    {
        // Récupérer les stagiaires de la table `dsi`
        $demandes = DB::table('dsi')->get();

        // Récupérer les tâches liées au poste DSI
        $tasks = DB::table('tasks')->where('poste', 'dsi')->get();

        // Retourner la vue avec les stagiaires et les tâches
        return view('dashboard.dsi_tasks', compact('demandes', 'tasks'));
    }

    public function assignTask(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required|exists:dsi,id', // Vérifie que l'ID existe dans la table `dsi`
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'required|string',
            'taskDeadline' => 'required|date',
            'taskTime' => 'required|date_format:H:i',
        ]);

        try {
            DB::table('tasks')->insert([
                'user_id' => $validated['userId'],
                'title' => $validated['taskTitle'],
                'description' => $validated['taskDescription'],
                'deadline_date' => $validated['taskDeadline'],
                'deadline_time' => $validated['taskTime'],
                'poste' => 'dsi',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'assignation de la tâche : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue.']);
        }
    }
}
