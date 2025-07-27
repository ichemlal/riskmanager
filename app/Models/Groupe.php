<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
      protected $fillable = ['nom', 'description', 'structure_id'];

    public function salaries()
    {
        return $this->belongsToMany(Salarie::class, 'groupe_salarie');
    }
public function structure()
{
    return $this->belongsTo(Structure::class);
}
}
