<?php

namespace App\Models;

use App\Http\Traits\BelongsToProject;
use App\Models\Article;
use App\Models\Projet;
use App\Scopes\ProjetScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;
    use BelongsToProject;

    public function articles()
    {
        return $this->hasMany(Article::class);
    }   

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }       

    protected static function booted()
    {
        static::addGlobalScope(new ProjetScope);
    }
}
