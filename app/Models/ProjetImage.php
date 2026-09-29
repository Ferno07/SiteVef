<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjetImage extends Model
{
    protected $fillable = [
        'projet_id',
        'chemin',
        'ordre',
    ];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
