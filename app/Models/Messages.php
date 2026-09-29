<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'objet',
        'message',
        'lu',
    ];

}
