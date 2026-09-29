<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidature_nom',
        'candidature_prenom',
        'candidature_dateNaissance',
        'candidature_email',
        'candidature_telephone',
        'candidature_adresse',
        'candidature_typeParticipation',
        'candidature_autreType',
        'candidature_disponibilites',
        'candidature_preferenceAction',
        'candidature_motivation',
        'candidature_rgpd',
    ];
}
