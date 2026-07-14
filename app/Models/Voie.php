<?php

namespace App\Models;

use App\Models\Produit;
use App\Scopes\ProjetScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voie extends Model
{
    use HasFactory;
    protected $fillable = ['Largeur', 'projet_id'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_voie');
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
