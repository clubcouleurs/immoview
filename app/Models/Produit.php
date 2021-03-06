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

    public function paiements()
    {
        return $this->hasManyThrough(Paiement::class, Dossier::class );
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
        elseif (isset($this->office)) {
            return 'office' ;
        }
        elseif (isset($this->box)) {
            return 'box' ;
        }                
    }

    public static function produitsParType()
    {       
        return \DB::table('produits')
                ->select('constructible_type', \DB::raw('COUNT(*) as nombre'))
                ->groupBy('constructible_type')
                ->get();
    } 

    public function getPrixAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return round(250000 / $this->constructible->surface) ;
        }
      
        return $prix = ($this->prixM2Definitif === 0 || $this->prixM2Definitif == Null) ? $this->prixM2Indicatif : $this->prixM2Definitif ;
    }
    public function getTotalDefinitifAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return 250000 ;
        }

        return $this->prixM2Definitif * $this->constructible->surface ;
    } 
    public function getTotalIndicatifAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return 250000 ;
        }        
        return $this->prixM2Indicatif * $this->constructible->surface ;
    }     
    public function getTotalAttribute()
    {
        return $this->prix * $this->constructible->surface ;
    }  

    public function getRemiseAttribute()
    {
        if ($this->constructible->type === 'Economique')
        {
            return 0 ;
        }         
        return round(100 - (($this->prixM2Definitif * 100) / $this->prixM2Indicatif ) , 2) ;
    } 
    public function getRemiseNatureAttribute()
    {
        return ($this->remise > 0 ) ? 'Remise' : 'Augmentation' ;
    } 

    public function getNombreVoiesAttribute()
    {
        return count($this->voies) ;
    }
    public function getQuellesVoiesAttribute()
    {
        $voies = '' ;
        foreach ($this->voies as $voie)
        {
                        $voies = $voies  . $voie->Largeur . ' | ' ;
        }
        return $voies ;

    }     
}
