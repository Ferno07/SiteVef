<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['published_at' => 'datetime'];

    public function scopePublished($q)
    {
        return $q->where('publication', 'publie')->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function projets()
    {
        return $this->belongsToMany(Projet::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
