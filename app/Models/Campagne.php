<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campagne extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'participants',
        'user_id',
        'emails',
    ];

    protected $casts = [
        'emails' => 'array',
        'date_debut' => 'date',
        'date_fin' => 'date',
    ];

    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'campagne_groupe');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'campagne_question');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    // Get completion percentage
    public function getCompletionPercentageAttribute()
    {
        $totalRequired = $this->questions->count() * $this->groupes->sum(function($groupe) {
            return $groupe->salaries->count();
        });
        
        if ($totalRequired == 0) return 0;
        
        $completed = $this->responses->count();
        return round(($completed / $totalRequired) * 100, 2);
    }

    // Get average criticality for this campaign
    public function getAverageCriticalityAttribute()
    {
        return $this->responses()->avg('criticality') ?? 0;
    }
}
