<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dpaf extends Model
{
    use HasFactory;

    protected $table = 'dpaf'; // Nom de la table

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'filiere',
    ];
}
