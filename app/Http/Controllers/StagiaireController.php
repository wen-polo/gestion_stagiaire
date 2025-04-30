<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StagiaireController extends Controller
{
    public function index()
    {
        // Vous pouvez passer des données dynamiques ici si nécessaire
        return view('admin.stagiaires');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérifier dans chaque table
        $tables = ['secretaria', 'dsi', 'service_comptabilite', 'dpaf'];
        foreach ($tables as $table) {
            $stagiaire = DB::table($table)->where('email', $validated['email'])->first();
            if ($stagiaire && \Hash::check($validated['password'], $stagiaire->password)) {
                // Authentification réussie
                return redirect()->route('stagiaire.show', ['poste' => $table, 'email' => $stagiaire->email]);
            }
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    public function profile(Request $request, $poste, $email)
    {
        // Liste des tables valides
        $tables = ['dsi', 'secretaria', 'service_comptabilite', 'dpaf'];

        // Vérifier que le poste est valide
        if (!in_array($poste, $tables)) {
            abort(404, 'Poste invalide.');
        }

        // Récupérer les informations du stagiaire dans la table correspondante
        $stagiaire = DB::table($poste)->where('email', $email)->first();

        if (!$stagiaire) {
            abort(404, 'Stagiaire non trouvé.');
        }

        // Récupérer les tâches assignées au stagiaire
        $tasks = DB::table('tasks')->where('user_id', $stagiaire->id)->get();

        // Retourner la vue avec les données
        return view('stagiaire.profile', [
            'stagiaire' => $stagiaire,
            'poste' => $poste,
            'tasks' => $tasks,
        ]);
    }
}
