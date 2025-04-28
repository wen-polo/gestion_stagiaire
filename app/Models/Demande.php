<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'filiere',
        'niveau',
        'diplome',
        'type_stage',
        'statut_stage',
        'date_debut',
        'date_fin',
        'contacts',
        'pdf_path',
        'statut',
        'poste_affectation', // Ajoutez cette ligne
    ];
}
