<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'description_longue',
        'image',
    ];

    public function images()
    {
        return $this->hasMany(ProjetImage::class)->orderBy('ordre');
    }

    public function getGalerieAttribute(): array
    {
        if ($this->images->isNotEmpty()) {
            return $this->images->map(fn ($img) => asset($img->chemin))->values()->all();
        }

        return $this->image ? [asset($this->image)] : [];
    }
}
