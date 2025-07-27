<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salarie extends Model
{
    use HasFactory;
    protected $fillable = [
        'prenom', 'nom', 'email', 'telephone', 'date_embauche', 'metier_id','structure_id', 'user_id'
    ];

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }
    public function structure()
{
    return $this->belongsTo(Structure::class);
}
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'groupe_salarie');
    }
    
    public function responses()
    {
        return $this->hasMany(Response::class);
    }
    
}
