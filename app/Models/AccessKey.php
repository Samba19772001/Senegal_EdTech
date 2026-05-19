<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessKey extends Model
{
    protected $fillable = [
        'cle', 'est_utilisee', 'user_id', 'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}