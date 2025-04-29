<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Demande;

class Demande extends Model
{
    use HasFactory, Notifiable;

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
        'poste_affectation',
    ];
}
