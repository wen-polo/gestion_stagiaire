<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Models\ServiceComptabilite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Notifications\StagiairePasswordNotification;
use Illuminate\Support\Str;

class DemandeController extends Controller
{
    public function index()
    {
        // Vous pouvez passer des données dynamiques ici si nécessaire
        return view('admin.demandes');
    }

    public function create()
    {
        return view('demande.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Validation de l'email
            'filiere' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'diplome' => 'required|string|max:255',
            'type_stage' => 'required|in:academique,professionnel',
            'statut_stage' => 'required|in:initial,renouvellement',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'contacts' => 'required|string|max:255',
            'pdf' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Gérer l'upload du fichier PDF
        $pdfPath = $request->file('pdf')->store('demandes', 'public');

        // Créer la demande avec l'email et le chemin du fichier PDF
        Demande::create(array_merge($validated, ['pdf_path' => $pdfPath]));

        return redirect()->route('demande.create')->with('success', 'Votre demande a été soumise avec succès.');
    }

    public function dashboardDpaf()
    {
        // Récupérer toutes les demandes
        $demandes = Demande::all();
        return view('dashboard.dpaf', compact('demandes'));
    }

    public function dashboardDpafPost()
    {
        // Récupérer les données de la table dpaf
        $demandes = DB::table('dpaf')->get();

        // Log des données récupérées pour débogage
        \Log::info('Données récupérées pour DPAF : ', $demandes->toArray());

        // Retourner la vue avec les données
        return view('dashboard.dpaf_post', compact('demandes'));
    }

    public function transfererDpaf($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->update(['statut' => 'transferee_dpaf']);

        return redirect()->route('dashboard.dpaf')->with('success', 'Demande transférée au SRHDS avec succès.');
    }

    public function dashboardSrhds()
    {
        // Récupérer les demandes avec le statut "transferee_dpaf"
        $demandes = Demande::where('statut', 'transferee_dpaf')->get();
        return view('dashboard.srhds', compact('demandes'));
    }

    public function transferer($id)
    {
        // Trouver la demande et mettre à jour son statut
        $demande = Demande::findOrFail($id);
        $demande->update(['statut' => 'transferee']);

        return redirect()->route('dashboard.dpaf')->with('success', 'Demande transférée avec succès.');
    }

    public function dashboardSg()
    {
        // Récupérer toutes les demandes
        $demandes = Demande::all();
        return view('dashboard.sg', compact('demandes'));
    }

    public function transfererSg($id)
    {
        $demande = Demande::findOrFail($id);
        $demande->update(['statut' => 'transferee_sg']);

        return redirect()->route('dashboard.sg')->with('success', 'Demande transférée au DPAF avec succès.');
    }

    public function analysed()
    {
        // Récupérer les demandes avec le statut "transferee_dpaf" ou tout autre critère
        $demandes = Demande::where('statut', 'transferee_dpaf')->get();
        return view('dashboard.analysed', compact('demandes'));
    }

    public function show($id)
    {
        $demande = Demande::findOrFail($id);

        return response()->json([
            'nom' => $demande->nom,
            'prenom' => $demande->prenom,
            'email' => $demande->email,
            'filiere' => $demande->filiere,
            'niveau' => $demande->niveau,
            'diplome' => $demande->diplome,
            'pdf_path' => $demande->pdf_path,
        ]);
    }

    public function affecter(Request $request, $id)
    {
        \Log::info('Données reçues pour affectation : ', $request->all());

        $demande = Demande::findOrFail($id);

        if (!$request->has('poste_affectation')) {
            \Log::error('Le poste d\'affectation est manquant.');
            return response()->json(['success' => false, 'message' => 'Le poste d\'affectation est manquant.']);
        }

        $poste = $request->poste_affectation;
        $demande->update(['poste_affectation' => $poste]);

        \Log::info('Poste affecté avec succès : ', ['poste_affectation' => $poste]);

        return response()->json(['success' => true, 'poste_affectation' => $poste]);
    }

    public function confirmer($id)
    {
        try {
            \Log::info('Début de la méthode confirmer pour la demande ID : ' . $id);

            $demande = Demande::findOrFail($id);
            \Log::info('Demande trouvée : ', $demande->toArray());

            if (!$demande->poste_affectation) {
                \Log::error('Poste d\'affectation non défini pour la demande ID : ' . $id);
                return response()->json(['success' => false, 'message' => 'Le poste d\'affectation n\'est pas défini pour cette demande.']);
            }

            // Générer un mot de passe aléatoire
            $plainPassword = Str::random(8); // Mot de passe en clair
            $hashedPassword = bcrypt($plainPassword); // Mot de passe hashé
            \Log::info('Mot de passe généré pour la demande ID : ' . $id);

            // Insérer les données dans la table correspondante
            switch ($demande->poste_affectation) {
                case 'Secretaria':
                    DB::table('secretaria')->insert([
                        'nom' => $demande->nom,
                        'prenom' => $demande->prenom,
                        'email' => $demande->email,
                        'filiere' => $demande->filiere,
                        'date_debut' => $demande->date_debut,
                        'date_fin' => $demande->date_fin,
                        'password' => $hashedPassword,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'DSI':
                    DB::table('dsi')->insert([
                        'nom' => $demande->nom,
                        'prenom' => $demande->prenom,
                        'email' => $demande->email,
                        'filiere' => $demande->filiere,
                        'date_debut' => $demande->date_debut,
                        'date_fin' => $demande->date_fin,
                        'password' => $hashedPassword,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'Service Comptabilité':
                    DB::table('service_comptabilite')->insert([
                        'nom' => $demande->nom,
                        'prenom' => $demande->prenom,
                        'email' => $demande->email,
                        'filiere' => $demande->filiere,
                        'date_debut' => $demande->date_debut,
                        'date_fin' => $demande->date_fin,
                        'password' => $hashedPassword,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                case 'DPAF':
                    DB::table('dpaf')->insert([
                        'nom' => $demande->nom,
                        'prenom' => $demande->prenom,
                        'email' => $demande->email,
                        'filiere' => $demande->filiere,
                        'date_debut' => $demande->date_debut,
                        'date_fin' => $demande->date_fin,
                        'password' => $hashedPassword,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    break;

                default:
                    \Log::error('Poste d\'affectation inconnu pour la demande ID : ' . $id);
                    return response()->json(['success' => false, 'message' => 'Poste d\'affectation inconnu.']);
            }

            \Log::info('Données insérées avec succès pour la demande ID : ' . $id);

            // Envoyer la notification avec le mot de passe en clair
            $demande->notify(new StagiairePasswordNotification($plainPassword));
            \Log::info('Notification envoyée pour la demande ID : ' . $id);

            // Mettre à jour le statut de la demande
            $demande->update(['affectation_statut' => 'confirme']);
            \Log::info('Statut de la demande mis à jour pour la demande ID : ' . $id);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Erreur dans la méthode confirmer : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Une erreur est survenue.']);
        }
    }

    public function dashboardPoste($poste)
    {
        // Bloquer l'accès à "comptabilite" via la route dynamique
        if ($poste === 'comptabilite') {
            abort(404); // Retourne une erreur 404
        }

        // Récupérer les données dynamiquement pour les autres postes
        $demandes = DB::table($poste)->get();

        // Retourner la vue correspondante
        return view("dashboard.$poste", compact('demandes'));
    }

    public function dashboardDsi()
    {
        $demandes = DB::table('dsi')->get();

        // Log des données récupérées
        \Log::info('Données récupérées pour DSI : ', $demandes->toArray());

        return view('dashboard.dsi', compact('demandes'));
    }

    public function dashboardComptabilite()
    {
        // Récupérer les données de la table service_comptabilite
        $demandes = DB::table('service_comptabilite')->get();

        // Log des données récupérées pour débogage
        \Log::info('Données récupérées pour Service Comptabilité : ', $demandes->toArray());

        // Retourner la vue avec les données
        return view('dashboard.comptabilite', compact('demandes'));
    }

    public function dashboardSecretaria()
    {
        // Récupérer les données de la table secretaria
        $demandes = DB::table('secretaria')->get();

        // Log des données récupérées pour débogage
        \Log::info('Données récupérées pour Secretaria : ', $demandes->toArray());

        // Retourner la vue avec les données
        return view('dashboard.secretaria', compact('demandes'));
    }

    public function showStagiaire($poste, $email)
    {
        // Récupérer les données du stagiaire dans la table correspondante
        $stagiaire = DB::table($poste)->where('email', $email)->first();

        if (!$stagiaire) {
            abort(404, 'Stagiaire non trouvé.');
        }

        return view('stagiaire.profile', compact('stagiaire', 'poste'));
    }

    public function showDsi($id)
    {
        $demande = DB::table('dsi')->where('id', $id)->first();

        if (!$demande) {
            return response()->json(['error' => 'Demande non trouvée.'], 404);
        }

        return response()->json([
            'nom' => $demande->nom,
            'prenom' => $demande->prenom,
            'email' => $demande->email,
            'filiere' => $demande->filiere,
            'date_debut' => $demande->date_debut,
            'date_fin' => $demande->date_fin,
        ]);
    }

    public function showDpaf($id)
    {
        $demande = DB::table('dpaf')->where('id', $id)->first();

        if (!$demande) {
            return response()->json(['error' => 'Demande non trouvée.'], 404);
        }

        return response()->json([
            'nom' => $demande->nom,
            'prenom' => $demande->prenom,
            'email' => $demande->email,
            'filiere' => $demande->filiere,
            'date_debut' => $demande->date_debut,
            'date_fin' => $demande->date_fin,
        ]);
    }

    public function showSecretaria($id)
    {
        $demande = DB::table('secretaria')->where('id', $id)->first();

        if (!$demande) {
            return response()->json(['error' => 'Demande non trouvée.'], 404);
        }

        return response()->json([
            'nom' => $demande->nom,
            'prenom' => $demande->prenom,
            'email' => $demande->email,
            'filiere' => $demande->filiere,
            'date_debut' => $demande->date_debut,
            'date_fin' => $demande->date_fin,
        ]);
    }

    public function showComptabilite($id)
    {
        $demande = DB::table('service_comptabilite')->where('id', $id)->first();

        if (!$demande) {
            return response()->json(['error' => 'Demande non trouvée.'], 404);
        }

        return response()->json([
            'nom' => $demande->nom,
            'prenom' => $demande->prenom,
            'email' => $demande->email,
            'filiere' => $demande->filiere,
            'date_debut' => $demande->date_debut,
            'date_fin' => $demande->date_fin,
        ]);
    }
}
