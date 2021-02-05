<?php

namespace App\Models;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voie extends Model
{
    use HasFactory;
    protected $fillable = ['Largeur'];

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'produit_voie');
    }  
}
