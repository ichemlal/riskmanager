<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'campagne_id',
        'question_id',
        'salarie_id',
        'gravity',
        'frequency',
        'criticality'
    ];

    // Auto-calculate criticality before saving
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($response) {
            $response->criticality = $response->gravity * $response->frequency;
        });
    }

    public function campagne()
    {
        return $this->belongsTo(Campagne::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function salarie()
    {
        return $this->belongsTo(Salarie::class);
    }

    // Get criticality level as text
    public function getCriticalityLevelAttribute()
    {
        if ($this->criticality <= 5) return 'Très faible';
        if ($this->criticality <= 10) return 'Faible';
        if ($this->criticality <= 15) return 'Moyenne';
        if ($this->criticality <= 20) return 'Élevée';
        return 'Très élevée';
    }

    // Get criticality color for UI
    public function getCriticalityColorAttribute()
    {
        if ($this->criticality <= 5) return 'text-green-600';
        if ($this->criticality <= 10) return 'text-yellow-600';
        if ($this->criticality <= 15) return 'text-orange-600';
        if ($this->criticality <= 20) return 'text-red-600';
        return 'text-red-800';
    }
}
