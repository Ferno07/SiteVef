<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visite extends Model
{
    protected $fillable = ['date', 'ip_address', 'page'];

    protected $casts = ['date' => 'date'];
}
