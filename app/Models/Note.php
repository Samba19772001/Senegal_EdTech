<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'composition_id',
        'eleve_id',
        'matiere_id',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function composition()
    {
        return $this->belongsTo(Composition::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}