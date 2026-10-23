<?php

namespace App\Models;

class Donation extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = ['id'];

    protected $casts = ['confirmed_at' => 'datetime', 'amount_centimes' => 'integer'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
