<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;
     protected $fillable = [
        'nom_structure',
        'siret',
        'adresse',
        'code_postal',
        'ville',
        'email_contact',
        'secteur_activite',
        'nombre_employes',
        'user_id', // Ajout de l'attribut user_id pour lier la structure à un utilisateur
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function groupes()
    {
        return $this->hasMany(Groupe::class);
    }
    public function salaries()
    {
        return $this->hasMany(Salarie::class);
    }
    
    public function metiers()
    {
        return $this->hasMany(Metier::class);
    }
}
