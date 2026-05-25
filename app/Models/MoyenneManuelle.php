<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoyenneManuelle extends Model
{
    protected $table = 'moyennes_manuelles';
    
    protected $fillable = [
        'user_id',
        'eleve_id',
        'trimestre',
        'moyenne',
    ];

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}