<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'category',
        'risk_category',
        'color_code',
        'notes',
        'usage_count',
        'user_id',
        'structure_id'
    ];

    public function campagnes()
    {
        return $this->belongsToMany(Campagne::class, 'campagne_question');
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    // Get average criticality for this question across all responses
    public function getAverageCriticalityAttribute()
    {
        return $this->responses()->avg('criticality') ?? 0;
    }

    // Get responses count
    public function getResponsesCountAttribute()
    {
        return $this->responses()->count();
    }
}
