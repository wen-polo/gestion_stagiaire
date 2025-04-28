<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceComptabilite extends Model
{
    use HasFactory;

    protected $table = 'service_comptabilite'; // Nom de la table

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'filiere',
    ];
}
