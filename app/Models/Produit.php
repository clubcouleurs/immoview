<?php

namespace App\Models;

use App\Models\Dossier;
use App\Models\Lot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = ['prixM2Indicatif','prixM2Definitif', 'etiquette_id'];

    /*public function lot()
    {
        return $this->hasOne(Lot::class);
    }*/

    public function constructible()
    {
        return $this->morphTo();
    }

    public function voies()
    {
        return $this->belongsToMany(Voie::class, 'produit_voie');
    }  

    public function scopeTranche($query, $tranche)
    {
        return $query->where('lot.tranche_id', '=', $tranche);
    }

    public function etiquette()
    {
        return $this->belongsTo(Etiquette::class);
    }    
    public function dossier()
    {
        return $this->hasOne(Dossier::class);
    }

    public function getTypeAttribute()
    {
        if (isset($this->lot)) {
            return 'lot';
        }
        elseif (isset($this->appartement)) {
            return 'appartement' ;
        }
        elseif (isset($this->magasin)) {
            return 'magasin' ;
        }   
        elseif (isset($this->bureau)) {
            return 'bureau' ;
        }
        elseif (isset($this->box)) {
            return 'box' ;
        }                
    }
}
