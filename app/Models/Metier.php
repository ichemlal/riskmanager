<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metier extends Model
{
    use HasFactory;
        protected $fillable = ['nom', 'description', 'icon', 'structure_id'];
public function structure()
{
    return $this->belongsTo(Structure::class);
}
public function salarie()
{
    return $this->hasMany(Salarie::class);

}
}