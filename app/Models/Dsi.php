<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dsi extends Model
{
    use HasFactory;

    protected $table = 'dsi'; // Nom de la table

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'filiere',
    ];
}
