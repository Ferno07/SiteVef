<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{

    // Colonnes autorisées à être remplies
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'objet',
        'message',
    ];

}
