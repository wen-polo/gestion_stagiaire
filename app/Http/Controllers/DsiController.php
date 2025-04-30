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
            'userId' => 'required|exists:dsi,id',
            'taskDescription' => 'required|string|max:255',
        ]);

        DB::table('tasks')->insert([
            'user_id' => $validated['userId'],
            'description' => $validated['taskDescription'],
            'poste' => 'dsi', // Indique que la tâche est liée à DSI
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);
    }
}
