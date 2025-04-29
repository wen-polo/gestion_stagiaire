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
}
