<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'composition_id',
        'eleve_id',
        'moyenne_generale',
        'rang',
        'mention',
        'pdf_path',
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
}