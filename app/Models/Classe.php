<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nom',
        'annee_scolaire',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eleves()
    {
        return $this->hasMany(Eleve::class);
    }

    public function compositions()
    {
        return $this->hasMany(Composition::class);
    }
}