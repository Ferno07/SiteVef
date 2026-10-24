<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgrammeParrainage extends Model
{
    public const ENFANT = 'enfant';

    public const SANTE = 'sante';

    protected $table = 'programmes_parrainage';

    // Le code identifie le parcours : il n’est jamais modifiable par le formulaire.
    protected $fillable = [
        'titre',
        'accroche',
        'description',
        'montant_mensuel_centimes',
        'image',
        'image_alt',
    ];

    protected $casts = ['montant_mensuel_centimes' => 'integer'];

    public function getContactSubjectAttribute(): string
    {
        return 'Demande d’information — '.$this->titre;
    }

    public function getContactUrlAttribute(): string
    {
        return route('index', ['parrainage' => $this->code]).'#contact';
    }
}
